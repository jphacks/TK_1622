package www.jigenji.biz.jphacks;

import android.app.ActionBar;
import android.content.Context;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.os.AsyncTask;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
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

import android.widget.ArrayAdapter;
import android.widget.GridView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
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
import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashMap;
import java.util.List;

/**
 * Created by jigenjisk on 2016/10/28.
 */
public class GridFragment extends Fragment{

    private static final String ARG_SECTION_NUMBER = "section_number";

    private SharedPreferences sharedpre;
    private UserTommorowTask mAuthTask = null;
    private String checklist;

    public GridFragment() {
    }
    /**
     * Returns a new instance of this fragment for the given section
     * number.
     */
    // コンストラクタにkey:valueを渡したPlaceholderFragment型を返す
    public static GridFragment newInstance(int sectionNumber) {

        GridFragment fragment = new GridFragment();
        Bundle args = new Bundle();
        // key : value の保存
        args.putInt(ARG_SECTION_NUMBER, sectionNumber);
        // bundleをセット
        fragment.setArguments(args);
        return fragment;
    }



    //fragment の create
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {

        sharedpre = getPrefs("SaveData",getActivity());
        String str = sharedpre.getString("username", "");
        String pas = sharedpre.getString("password", "");
        String all = sharedpre.getString("alldelivery", "");
        mAuthTask = new UserTommorowTask(str, pas, all);
        mAuthTask.execute((Void) null);


        Log.d("all",all);
        // rootとなるviewのクラスを格納
        View rootlistview = inflater.inflate(R.layout.fragment_grid, container, false);

        //gridviewのクラスを格納
        GridView mygridView = (GridView) rootlistview.findViewById(R.id.FGridView);

        // データの作成
        List<GridData> objects = new ArrayList<>();

//        for(int i=0;i<8;i++) {
//            GridData item = new GridData();
//            item.setgridIcon(myicon);
//            item.setgridTitle("PC parts");
//            item.setgridValue("ヤマト運輸");
//            objects.add(item);
//        }

        Log.d("todaystring",Functions.Today());
        try{
            JSONArray rootArray = new JSONArray(all);
            int count = rootArray.length();

            for(int i=0; i<count;i++){
                JSONObject rooobject = rootArray.getJSONObject(i);
                GridData item = new GridData();
                if(!rooobject.getString("scheduledday").equals(Functions.Today())) {
                    Log.d("scheduledday",rooobject.getString("scheduledday"));
                    item.setgridCompany(rooobject.getString("companyflag"));
                    item.setgridIcon(Functions.getCompanyBitmap(rooobject.getString("companyflag"), getActivity()));
                    item.setgridTitle(Functions.getMonthDay(rooobject.getString("scheduledday")));
                    item.setgridValue(rooobject.getString("deliveryname"));
                    objects.add(item);
                }
            }

            Log.d("tommorow",Integer.toString(count));
        }catch (JSONException e){
            Log.d("jsonerror","cant");
        }


        AllGridAdapter custom = new AllGridAdapter(getActivity(),R.layout.grid_item, objects);

        mygridView.setAdapter(custom);


        return rootlistview;
    }

    public class UserTommorowTask extends AsyncTask<Void, Void, Boolean> {

        private final String mUsername;
        private final String mPassword;
        private final String mAll;
        private String result;

        HttpURLConnection con = null;

        // コンストラクタ,email,passwordを代入
        UserTommorowTask(String username, String password,String all) {
            mUsername = username;
            mPassword = password;
            mAll = all;
        }

        //非同期処理の本体
        //引数は非同期処理内容を渡すためのパラメタ配列
        @Override
        protected Boolean doInBackground(Void... params) {
            try {
                URL urlLogin = new URL("http://www.jigenji.biz/server/controller/LoginController_s.php");
                con = (HttpURLConnection) urlLogin.openConnection();
                con.setConnectTimeout(100000);
                con.setReadTimeout(100000);
                con.setRequestMethod("POST");
                con.setRequestProperty("Accept-Language", "jp");
                con.setDoOutput(true);
                con.setDoInput(true);
                con.setRequestProperty("Content-Type", "application/json; charset=utf-8");
                con.connect();

                //outputstreamを開く
                OutputStream outputStream = con.getOutputStream();

                //送る連想配列を指定
                HashMap<String, Object> jsonMap = new HashMap<>();
                jsonMap.put("flag" , "LI");
                jsonMap.put("username" , mUsername);
                jsonMap.put("password" , mPassword);

                // jsonファイルを送信
                if (jsonMap.size() > 0) {
                    //JSON形式の文字列に変換する。
                    JSONObject responseJsonObject = new JSONObject(jsonMap);
                    // json形式の書式で出力
                    String jsonText = responseJsonObject.toString();
                    PrintStream ps = new PrintStream(con.getOutputStream());
                    ps.print(jsonText);
                    ps.close();
                }

                outputStream.close();


                String responseData = "";
                int statusCode = con.getResponseCode();
                InputStream inputstream = con.getInputStream();
                StringBuffer sb = new StringBuffer();
                String line = "";
                BufferedReader br = new BufferedReader(new InputStreamReader(inputstream, "UTF-8"));
                while ((line = br.readLine()) != null) {
                    sb.append(line);
                }
                inputstream.close();
                responseData = sb.toString();
                result = responseData;

                Log.d("resultTommorow",result);
                con.disconnect();


                Thread.sleep(0);
            } catch (InterruptedException e) {
                return false;
            } catch (MalformedURLException e){
                return false;
            }   catch (IOException e){
                return false;
            }

            return true;
        }

        //非同期処理実行後にUIスレッドで実行する処理
        //引数はexecute()の返り値
        @Override
        protected void onPostExecute(final Boolean success) {
            if(!mAll.equals(result)){
                SharedPreferences prefs = getPrefs("SaveData" ,getActivity());
                SharedPreferences.Editor editor = prefs.edit();
                editor.putString("all", result);
                editor.apply();
            }

        }

        //cancelメソッドが呼び出された時に実行
        @Override
        protected void onCancelled() {

        }
    }

    private static SharedPreferences getPrefs(String string,Context context) {
        return context.getSharedPreferences(string, Context.MODE_PRIVATE);
    }


}
