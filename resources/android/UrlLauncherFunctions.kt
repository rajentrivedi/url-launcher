package com.nativephp.plugins.url_launcher

import android.content.Context
import android.content.Intent
import android.net.Uri
import android.content.ActivityNotFoundException
import androidx.fragment.app.FragmentActivity
import com.nativephp.mobile.bridge.BridgeFunction
import com.nativephp.mobile.bridge.BridgeResponse

object UrlLauncherFunctions {

    class Execute(private val activity: FragmentActivity) : BridgeFunction {
        override fun execute(parameters: Map<String, Any>): Map<String, Any> {
            val url = parameters["url"] as? String ?: return BridgeResponse.error(com.nativephp.mobile.bridge.BridgeError.InvalidParameters("No URL provided"))
            val action = parameters["action"] as? String ?: "launch"

            val intent = Intent(Intent.ACTION_VIEW, Uri.parse(url))

            if (action == "canLaunch") {
                val packageManager = activity.packageManager
                val resolves = intent.resolveActivity(packageManager) != null
                return BridgeResponse.success(mapOf("success" to resolves, "message" to (if (resolves) "Can launch" else "Cannot resolve intent")))
            }

            try {
                activity.startActivity(intent)

                return BridgeResponse.success(mapOf(
                    "success" to true,
                    "message" to "Launched successfully"
                ))
            } catch (e: ActivityNotFoundException) {
                return BridgeResponse.success(mapOf(
                    "success" to false,
                    "message" to e.localizedMessage
                ))
            } catch (e: Exception) {
                return BridgeResponse.error(com.nativephp.mobile.bridge.BridgeError.ExecutionFailed(e.localizedMessage ?: "Unknown error occurred"))
            }
        }
    }

    class GetStatus(private val context: Context) : BridgeFunction {
        override fun execute(parameters: Map<String, Any>): Map<String, Any> {
            return BridgeResponse.success(mapOf(
                "status" to "ready",
                "version" to "1.0.0"
            ))
        }
    }
}