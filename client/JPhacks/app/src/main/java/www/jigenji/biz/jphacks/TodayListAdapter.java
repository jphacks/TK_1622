package www.jigenji.biz.jphacks;

import android.content.Context;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.List;

/**
 * Created by jigenjisk on 2016/11/03.
 */
public class TodayListAdapter extends ArrayAdapter<ListData> {
    private LayoutInflater mLayoutInflater;

    public TodayListAdapter(Context context,int textViewResourceId, List<ListData> objects) {
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
            view = mLayoutInflater.inflate(R.layout.list_item_test, parent, false);
        } else {
            // レイアウトが存在する場合は再利用する
            view = convertView;
        }

        // リストアイテムに対応するデータを取得する
        ListData item = getItem(position);

        ImageView image1View;
        image1View = (ImageView)view.findViewById(R.id.imageView);
        image1View.setImageBitmap(item.getlistIcon());

        TextView text1View;
        text1View = (TextView)view.findViewById(R.id.TitleText);
        text1View.setText(item.getlistTitle());
//
        TextView text2View;
        text2View = (TextView)view.findViewById(R.id.SubTitleText);
        text2View.setText(item.getlistValue());


        return view;
    }
}
