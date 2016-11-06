package www.jigenji.biz.jphacks;

import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;

import java.util.Calendar;

/**
 * Created by jigenjisk on 2016/11/06.
 */
public class Functions {

    public static Bitmap getCompanyBitmap(String number,Context context){
        switch (number){
            case "1":
                Bitmap yamato;
                yamato = BitmapFactory.decodeResource(context.getResources(), R.drawable.yamato_iv);
                return yamato;
            case "2":
                Bitmap sagawa;
                sagawa = BitmapFactory.decodeResource(context.getResources(), R.drawable.sagawa_iv);
                return sagawa;
            case "3":
                Bitmap yubin;
                yubin = BitmapFactory.decodeResource(context.getResources(), R.drawable.nipponyubin_iv);
                return yubin;
            case "4":
                Bitmap seino;
                seino = BitmapFactory.decodeResource(context.getResources(), R.drawable.seinou_iv);
                return seino;
            case "5":
                Bitmap hukuyama;
                hukuyama = BitmapFactory.decodeResource(context.getResources(), R.drawable.hukuyama_iv);
                return hukuyama;
            default:
                Bitmap normal;
                normal = BitmapFactory.decodeResource(context.getResources(), R.drawable.mynet);
                return normal;

        }
    }

    public static String getCompanyName(String number){
        switch (number){
            case "1":
                return "ヤマト運輸";
            case "2":
                return "佐川急便";
            case "3":
                return "日本郵便";
            case "4":
                return "西濃運輸";
            case "5":
                return "福山通運";
            default:
                return "No Name";

        }
    }

    public static String getMonthDay(String data){
        return data.substring(data.length()-5).replaceAll("-","/");
    }

    public static int getCompanyColor(String company, int number){
        switch (company){
            case "1":
                if(number == 1){
                    return Color.parseColor("#c7ddae");
                }else {
                    return Color.parseColor("#85beab");
                }
            case "2":
                if(number == 1){
                    return Color.parseColor("#b1d7e4");
                }else{
                    return Color.parseColor("#6490cd");
                }
            case "3":
                if(number == 1){
                    return Color.parseColor("#f2dae8");
                }else{
                    return Color.parseColor("#d8836e");
                }
            case "4":
                if(number == 1){
                    return Color.parseColor("#e8e6f3");
                }else{
                    return Color.parseColor("#7f7eb8");
                }
            case "5":
                if(number == 1){
                    return Color.parseColor("#eef0b1");
                }else{
                    return Color.parseColor("#c59f22");
                }
            default:
                return Color.parseColor("#FF00C0");

        }
    }

    public static String Today(){
        Calendar cal = Calendar.getInstance();
        String today ;
        if(cal.get(Calendar.DATE) < 10){
            return (cal.get(Calendar.YEAR) + "-" + "11-0"+ cal.get(Calendar.DATE));
        }else{
            return (cal.get(Calendar.YEAR) + "-" + "11-"+ cal.get(Calendar.DATE));
        }

    }

    public static String Settings(int number, String time1, String time2){
        switch (number){
            case 0:
                return "設定: なし";
            case 1:
                return "設定: 時間指定 "+ time2 +" ~ " +time1;
            case 2:
                return "設定: 今から受け取る";
            case 3:
                return "設定: 後で決める";
            case 4:
                return "設定: 今日は受け取らない";
            default:
                return "No Request";

        }

    }

    public static String Default(int number, String time1, String time2){
        switch (number){
            case 0:
                return "いつもの時間は設定されていません";
            case 1:
                return "いつもの時間: "+ time2 +" ~ " +time1;
            default:
                return "No Data";

        }

    }


}
