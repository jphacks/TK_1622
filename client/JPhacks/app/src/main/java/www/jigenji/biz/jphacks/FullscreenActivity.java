package www.jigenji.biz.jphacks;

import android.annotation.SuppressLint;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;

import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.PrintStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;

/**
 * An example full-screen activity that shows and hides the system UI (i.e.
 * status bar and navigation/system bar) with user interaction.
 */
public class FullscreenActivity extends AppCompatActivity {

    private static final int AUTO_HIDE_DELAY_MILLIS = 3000;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_fullscreen);

        SharedPreferences prefs = getSharedPreferences("SaveData", Context.MODE_PRIVATE);
        String str = prefs.getString("statusicon", "");
        String usr = prefs.getString("username", "");
        String pas = prefs.getString("password", "");

        Log.d("status",str);
        Log.d("usr",usr);
        Log.d("pas",pas);

        UserChangeTask stack = new UserChangeTask(usr);

        stack.execute((Void) null);

    }


    public class UserChangeTask extends AsyncTask<Void, Void, Boolean> {

        private String mStatus;
        UserChangeTask(String String) {
            mStatus = String;
        }

        @Override
        protected Boolean doInBackground(Void... params) {
            try{
                Thread.sleep(2000);
            } catch (InterruptedException e) {

            }
            if(mStatus == "" || mStatus == null){

                return false;
            }else{

                return true;

            }


        }

        @Override
        protected void onPostExecute(final Boolean success) {
            if(success){
                Intent intent = new Intent(FullscreenActivity.this , MainActivity.class);
                startActivity(intent);
                finish();
            }else{
                Intent intent = new Intent(FullscreenActivity.this , LoginActivity.class);
                startActivity(intent);
                finish();
            }

        }

        @Override
        protected void onCancelled() {

        }
    }

}
