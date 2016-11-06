package www.jigenji.biz.jphacks;

import android.app.Dialog;
import android.app.TimePickerDialog;
import android.content.Context;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.net.Uri;
import android.support.design.widget.Snackbar;
import android.support.v4.app.DialogFragment;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.TimePicker;
import android.widget.Toast;

import com.google.android.gms.appindexing.Action;
import com.google.android.gms.appindexing.AppIndex;
import com.google.android.gms.common.api.GoogleApiClient;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

public class Main2Activity extends AppCompatActivity {

    /**
     * ATTENTION: This was auto-generated to implement the App Indexing API.
     * See https://g.co/AppIndexing/AndroidStudio for more information.
     */
    private GoogleApiClient client;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main2);



        final LinearLayout linear = (LinearLayout) findViewById(R.id.linear2_form);

        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar2);
        setSupportActionBar(toolbar);

        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setHomeButtonEnabled(true);

        ListView mylistView = (ListView) findViewById(R.id.submitlistView);


        ArrayList<SubmitData> submits = new ArrayList<>();

        SubmitData submit1 = new SubmitData();
        submit1.setsubmitTitle("時間を指定する");
        submits.add(submit1);

        SubmitData submit2 = new SubmitData();
        submit2.setsubmitTitle("今から受け取る");
        submits.add(submit2);

        SubmitData submit3 = new SubmitData();
        submit3.setsubmitTitle("後で決める");
        submits.add(submit3);

        SubmitData submit4 = new SubmitData();
        submit4.setsubmitTitle("今日は受け取らない");
        submits.add(submit4);

        SubmitData submit5 = new SubmitData();
        submit5.setsubmitTitle("いつもの時間");
        submits.add(submit5);

        UserAdapter custom = new UserAdapter(this, R.layout.list_item_submit, submits);

        mylistView.setAdapter(custom);



        // アイテムクリック時ののイベントを追加
        mylistView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            public void onItemClick(AdapterView<?> parent,
                                    View view, int pos, long id) {


                SharedPreferences prefs = getSharedPreferences("SaveData", Context.MODE_PRIVATE);
                SharedPreferences.Editor editor = prefs.edit();

                if (pos == 0) {
                    Snackbar.make(linear, "開始時間を設定してください", Snackbar.LENGTH_SHORT).show();
                    TimePickerDialogFragment timePicker = new TimePickerDialogFragment();
                    timePicker.show(getSupportFragmentManager(), "timePicker");
                    Snackbar.make(linear, "終了時間を設定してください", Snackbar.LENGTH_SHORT).show();
                    TimePickerDialogFragment2 timePicker2 = new TimePickerDialogFragment2();
                    timePicker2.show(getSupportFragmentManager(), "timePicker");
                    editor.putInt("request",1);
                }else if(pos == 1){
                    editor.putInt("request",2);
                }else if(pos == 2){
                    editor.putInt("request",3);
                }else if(pos == 3){
                    editor.putInt("request",4);
                }else if(pos == 4){
                    editor.putInt("request",1);
                    String time1d = prefs.getString("time1d","");
                    String time2d = prefs.getString("time2d","");
                    editor.putString("time1",time1d);
                    editor.putString("time2",time2d);

                }
                Snackbar.make(linear, "設定を完了しました", Snackbar.LENGTH_SHORT).show();
                editor.apply();

                int i = prefs.getInt("request", 0);
                String time1 = prefs.getString("time1","sa");
                String time2 = prefs.getString("time2","sa");

                Log.d("request", String.valueOf(i));
                Log.d("time1", time1);
                Log.d("time2", time2);

            }
        });


        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client = new GoogleApiClient.Builder(this).addApi(AppIndex.API).build();
    }

    @Override
    public void onStart() {
        super.onStart();

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        client.connect();
        Action viewAction = Action.newAction(
                Action.TYPE_VIEW, // TODO: choose an action type.
                "Main2 Page", // TODO: Define a title for the content shown.
                // TODO: If you have web page content that matches this app activity's content,
                // make sure this auto-generated web page URL is correct.
                // Otherwise, set the URL to null.
                Uri.parse("http://host/path"),
                // TODO: Make sure this auto-generated app URL is correct.
                Uri.parse("android-app://www.jigenji.biz.jphacks/http/host/path")
        );
        AppIndex.AppIndexApi.start(client, viewAction);
    }

    @Override
    public void onStop() {
        super.onStop();

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        Action viewAction = Action.newAction(
                Action.TYPE_VIEW, // TODO: choose an action type.
                "Main2 Page", // TODO: Define a title for the content shown.
                // TODO: If you have web page content that matches this app activity's content,
                // make sure this auto-generated web page URL is correct.
                // Otherwise, set the URL to null.
                Uri.parse("http://host/path"),
                // TODO: Make sure this auto-generated app URL is correct.
                Uri.parse("android-app://www.jigenji.biz.jphacks/http/host/path")
        );
        AppIndex.AppIndexApi.end(client, viewAction);
        client.disconnect();
    }


    public class UserAdapter extends ArrayAdapter<SubmitData> {

        private LayoutInflater mLayoutInflater;

        public UserAdapter(Context context, int textViewResourceId, List<SubmitData> objects) {
            // 第2引数はtextViewResourceIdとされていますが、カスタムリストアイテムを使用する場合は特に意識する必要のない引数です
            super(context, textViewResourceId, objects);
            // レイアウト生成に使用するインフレーター
            mLayoutInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {

            View view = null;

//         ListViewに表示する分のレイアウトが生成されていない場合レイアウトを作成する
            if (convertView == null) {
                // レイアウトファイルからViewを生成する
                view = mLayoutInflater.inflate(R.layout.list_item_submit, parent, false);
            } else {
                // レイアウトが存在する場合は再利用する
                view = convertView;
            }

            // リストアイテムに対応するデータを取得する
            SubmitData item = getItem(position);


            TextView text1View;
            text1View = (TextView) view.findViewById(R.id.submittext);
            text1View.setText(item.getsubmitTitle());
//


            return view;
        }
    }


    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();

        boolean result = true;

        switch (id) {
            case android.R.id.home:
                finish();
                break;
            default:
                result = super.onOptionsItemSelected(item);
        }

        return result;
    }

    public class SubmitData {
        private String submitTitle;


        public void setsubmitTitle(String text) {
            submitTitle = text;
        }

        public String getsubmitTitle() {
            return submitTitle;
        }


    }

}
