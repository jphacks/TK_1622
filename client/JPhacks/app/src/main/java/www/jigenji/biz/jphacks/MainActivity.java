package www.jigenji.biz.jphacks;

import android.app.ActionBar;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.design.widget.TabLayout;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;

import android.widget.TextView;
import android.widget.Toast;

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

public class MainActivity extends AppCompatActivity {

    //メニューのID
    private static final int MENU_ID_A = 0;
    private static final int MENU_ID_B = 1;
    private static final int MENU_ID_C = 2;

    /**
     * The {@link android.support.v4.view.PagerAdapter} that will provide
     * fragments for each of the sections. We use a
     * {@link FragmentPagerAdapter} derivative, which will keep every
     * loaded fragment in memory. If this becomes too memory intensive, it
     * may be best to switch to a
     * {@link android.support.v4.app.FragmentStatePagerAdapter}.
     */

    //page 切り替えを担当するアダプターを保管する変数を宣言
    private SectionsPagerAdapter mSectionsPagerAdapter;

    /**
     * The {@link ViewPager} that will host the section contents.
     */
    //ViewPagerはフリック用のlistviewを保管する変数を宣言
    private ViewPager mViewPager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

//        SharedPreferences data = getSharedPreferences("SaveData", Context.MODE_PRIVATE);
//        String str = data.getString("username","" );
//        String pas = data.getString("password","");


        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        TabLayout tabLayout = (TabLayout) findViewById(R.id.tab_layout);


        // Create the adapter that will return a fragment for each of the three
        // ViewPagerとListFragmentを紐付けつAdapterを生成
        // getfragmentviewmanager:FragmentManegerを返す
        // アダプター型変数に値を格納
        mSectionsPagerAdapter = new SectionsPagerAdapter(getSupportFragmentManager());

        // viewpager型変数に値を挿入
        // Set up the ViewPager with the sections adapter.
        mViewPager = (ViewPager) findViewById(R.id.container);
        // viewpagerにアダプターをセット
        mViewPager.setAdapter(mSectionsPagerAdapter);
        tabLayout.setupWithViewPager(mViewPager);

        //float buttonが押された時
        findViewById(R.id.fab).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity.this , Main2Activity.class);
                startActivity(intent);
            }
        });

    }

    //メニューバーに表示するメニュー
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
//        menu.add(Menu.NONE, MENU_ID_A, Menu.NONE, "アイテム A");
//        menu.add(Menu.NONE, MENU_ID_B, Menu.NONE, "アイテム B");
//        menu.add(Menu.NONE, MENU_ID_C, Menu.NONE, "アイテム C");
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    //メニューが押された時のアクション
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId(); //itemに各情報が入ってる

        //noinspection SimplifiableIfStatement
        //action_settings==menu_main
        if (id == R.id.action_settings) {


            SharedPreferences prefs = getSharedPreferences("SaveData", Context.MODE_PRIVATE);
            SharedPreferences.Editor editor = prefs.edit();
            editor.putString("username", null);
            editor.putString("password", null);
            editor.putString("statusicon", "false");
            editor.apply();
            SharedPreferences prefs2 = getSharedPreferences("MyListData", Context.MODE_PRIVATE);
            SharedPreferences.Editor editor2 = prefs2.edit();
            editor2.putString("today", null);
            editor2.putString("tommorow", null);
            editor2.apply();

            Intent intent = new Intent(MainActivity.this, LoginActivity.class);
            startActivity(intent);

            finish();
        }

//        switch (item.getItemId()) {
//            case MENU_ID_A:
//                Toast.makeText(this, "アイテム A", Toast.LENGTH_LONG).show();
//                return true;
//
//            case MENU_ID_B:
//                Toast.makeText(this, "アイテム B", Toast.LENGTH_LONG).show();
//                return true;
//
//            case MENU_ID_C:
//                Toast.makeText(this, "アイテム C", Toast.LENGTH_LONG).show();
//                return true;
//        }

        return super.onOptionsItemSelected(item);
    }
}
