import Foundation
import UIKit

enum UrlLauncherFunctions {

    class Execute: BridgeFunction {
        func execute(parameters: [String: Any]) throws -> [String: Any] {
            guard let urlString = parameters["url"] as? String,
                  let url = URL(string: urlString) else {
                return BridgeResponse.error(message: "No valid URL provided")
            }
            
            let action = parameters["action"] as? String ?? "launch"

            if action == "canLaunch" {
                let canOpen = UIApplication.shared.canOpenURL(url)
                return BridgeResponse.success(data: [
                    "success": canOpen,
                    "message": canOpen ? "Can launch" : "Cannot open URL scheme"
                ])
            }

            // We must dispatch to main thread for UI operations
            var launched = false
            let semaphore = DispatchSemaphore(value: 0)

            DispatchQueue.main.async {
                if UIApplication.shared.canOpenURL(url) {
                    UIApplication.shared.open(url, options: [:]) { success in
                        launched = success
                        semaphore.signal()
                    }
                } else {
                    semaphore.signal()
                }
            }

            semaphore.wait()

            if launched {
                return BridgeResponse.success(data: [
                    "success": true,
                    "message": "Launched successfully"
                ])
            } else {
                return BridgeResponse.success(data: [
                    "success": false,
                    "message": "Could not launch URL"
                ])
            }
        }
    }

    class GetStatus: BridgeFunction {
        func execute(parameters: [String: Any]) throws -> [String: Any] {
            return BridgeResponse.success(data: [
                "status": "ready",
                "version": "1.0.0"
            ])
        }
    }
}