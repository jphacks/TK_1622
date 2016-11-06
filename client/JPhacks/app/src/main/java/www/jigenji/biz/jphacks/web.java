package www.jigenji.biz.jphacks;

import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;

/**
 * Created by jigenjisk on 2016/11/05.
 */
public class web extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Uri uri = Uri.parse("http://www.jigenji.biz/login.php");
        Intent i = new Intent(Intent.ACTION_VIEW,uri);
        startActivity(i);
    }
}
