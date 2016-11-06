package www.jigenji.biz.jphacks;

import android.graphics.Bitmap;

/**
 * Created by jigenjisk on 2016/11/03.
 */
public class ListData {
    private Bitmap listIcon_;
    private String listTitle_;
    private String listValue_;


    public void setlistIcon(Bitmap image) {
        listIcon_ = image;
    }

    public Bitmap getlistIcon() {
        return listIcon_;
    }

    public void setlistTitle(String text) {
        listTitle_ = text;
    }

    public String getlistTitle() {
        return listTitle_;
    }

    public void setlistValue(String text) {
        listValue_ = text;
    }

    public String getlistValue() {
        return listValue_;
    }

}
