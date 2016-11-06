package www.jigenji.biz.jphacks;

import android.content.Context;
import android.graphics.Color;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import java.util.List;


/**
 * Created by jigenjisk on 2016/11/03.
 */
public class AllGridAdapter extends ArrayAdapter<GridData> {
    private LayoutInflater mLayoutInflater;

    public AllGridAdapter(Context context,int textViewResourceId, List<GridData> objects) {
        // 第2引数はtextViewResourceIdこれ絶対
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
            view = mLayoutInflater.inflate(R.layout.grid_item, parent, false);
        } else {
            // レイアウトが存在する場合は再利用する
            view = convertView;
        }

        // リストアイテムに対応するデータを取得する
        GridData item = getItem(position);

        LinearLayout image = (LinearLayout) view.findViewById(R.id.FrameImage);
        LinearLayout linear = (LinearLayout) view.findViewById(R.id.FrameLinear);
        image.setBackgroundColor(Functions.getCompanyColor(item.getgridCompany(),1));
        linear.setBackgroundColor(Functions.getCompanyColor(item.getgridCompany(),2));

        ImageView image1View;
        image1View = (ImageView)view.findViewById(R.id.GridImage);
        image1View.setImageBitmap(item.getgridIcon());

        TextView text1View;
        text1View = (TextView)view.findViewById(R.id.GridTitle);
        text1View.setText(item.getgridTitle());
//
        TextView text2View;
        text2View = (TextView)view.findViewById(R.id.GridSubTitle);
        text2View.setText(item.getgridValue());


        return view;
    }

}
