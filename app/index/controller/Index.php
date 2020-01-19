<?php

namespace app\index\controller;

use app\common\controller\Base as Base;
use app\common\model\Yzy as MyYzy;
use think\Controller;
use think\Db;
use think\Request;

// header("Access-Control-Allow-Origin:*");
// header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
// header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");

class Index extends Base
{
    public function indexAction(Request $request)
    {
        // $data=MyYzy::get('13261394996');
        // $this->assign('list',$data);
        // return $this->fetch();

        return json(MyYzy::select());
    }
    public function getDatasAction()
    {
        $data = Db::name('yzy')->group('lastname')->order('id asc')->select();
        // dump($data);
        // $where['order_num']=['like','%1'];
        // $where['order_id']=['>=','200'];
        // $where=[];
        // $data = Db::name('order_2019')->where($where)->order('order_id asc')->page('1,20')->select();
        if (count($data) >= 0) {
            $res = self::responseSuccessAction($data);
        } else {
            $res = self::responseFailAction("获取列表失败");
        }
        return json_encode($res);

        // $res=Db::field('a.id','b.order_id')->table(['yzy'=>'a','order_2019'=>'b']);
        // dump($res);
    }
    public function insertDataAction()
    {
        $data = Request::instance()->param();
        $result = Db::name('yzy')->insert($data);
        if (!$result) {
            $res = self::responseFailAction("添加失败");
        } else {
            $res = self::responseSuccessAction();
        }
        return json_encode($res);
    }
    public function deleteDataAction()
    {
        // $data = Request::instance()->param('id');
        // $result = Db::name('yzy')->where('id',$data)->delete();
        $data = Request::instance()->param();
        $result = Db::name('yzy')->delete($data);
        if (!$result) {
            $res = self::responseFailAction("删除失败");
        } else {
            $res = self::responseSuccessAction();
        }
        return json_encode($res);
    }
    public function updateDataAction()
    {
        $data = Request::instance()->param('phone');
        // $result=Db::name('yzy')->where("phone",$data)->update(["phone"=>'18516886719']);
        // $where[]=['id','>',1];
        $result = Db::name('yzy')->where('id>1', 'phone=18516886719')->update(["phone" => '13261394996']);
        if ($result === false) {
            $res = self::responseFailAction("修改失败");
        } else {
            $res = self::responseSuccessAction();
        }
        return json_encode($res);
    }

    public function insertDataToOrderAction()
    {
        $res = true;
        $data = Db::name('order_2019')->select();
        for ($i = 0; $i < 10; $i++) {
            $arr['order_num'] = count($data) + $i + 1;
            $arr['order_money'] = 1000.012;
            $arr['pay_money'] = 100.012;
            $res = Db::name('order_2019')->insert($arr);
        }
        if ($res) {
            return json(self::responseSuccessAction());
        } else {
            return json(self::responseFailAction("填充数据失败"));
        }
    }
    public function deleteFromOrderAction()
    {
        $where['order_id'] = ['>=', 1];
        $res = Db::name('order_2019')->where($where)->delete();
        if ($res) {
            $arr = self::responseSuccessAction();
        } else {
            $arr = self::responseFailAction('删除失败');
        }
        return json($arr);
    }
    public function testAction()
    {
        // $data=Order_2019::getById(228);
        // if($data){
        //     $res=$data->delete();
        //     return $res;
        // }else{
        //     return 0;
        // }
        $urls = array(
            "http://mobile.dazuhang.com/351.html", "http://mobile.dazuhang.com/352.html", "http://mobile.dazuhang.com/353.html", "http://mobile.dazuhang.com/355.html", "http://mobile.dazuhang.com/356.html", "http://mobile.dazuhang.com/357.html", "http://mobile.dazuhang.com/391.html", "http://mobile.dazuhang.com/1175.html", "http://mobile.dazuhang.com/1176.html", "http://mobile.dazuhang.com/1177.html", "http://mobile.dazuhang.com/1179.html", "http://mobile.dazuhang.com/1180.html", "http://mobile.dazuhang.com/1204.html", "http://mobile.dazuhang.com/1307.html", "http://mobile.dazuhang.com/1308.html", "http://mobile.dazuhang.com/1309.html", "http://mobile.dazuhang.com/1311.html", "http://mobile.dazuhang.com/1312.html", "http://mobile.dazuhang.com/1336.html", "http://mobile.dazuhang.com/413.html", "http://mobile.dazuhang.com/500.html", "http://mobile.dazuhang.com/1223.html", "http://mobile.dazuhang.com/1288.html", "http://mobile.dazuhang.com/1355.html", "http://mobile.dazuhang.com/1420.html", "http://mobile.dazuhang.com/358.html", "http://mobile.dazuhang.com/359.html", "http://mobile.dazuhang.com/360.html", "http://mobile.dazuhang.com/376.html", "http://mobile.dazuhang.com/378.html", "http://mobile.dazuhang.com/379.html", "http://mobile.dazuhang.com/380.html", "http://mobile.dazuhang.com/381.html", "http://mobile.dazuhang.com/383.html", "http://mobile.dazuhang.com/385.html", "http://mobile.dazuhang.com/388.html", "http://mobile.dazuhang.com/389.html", "http://mobile.dazuhang.com/392.html", "http://mobile.dazuhang.com/394.html", "http://mobile.dazuhang.com/469.html", "http://mobile.dazuhang.com/1181.html", "http://mobile.dazuhang.com/1182.html", "http://mobile.dazuhang.com/1183.html", "http://mobile.dazuhang.com/1195.html", "http://mobile.dazuhang.com/1196.html", "http://mobile.dazuhang.com/1197.html", "http://mobile.dazuhang.com/1198.html", "http://mobile.dazuhang.com/1199.html", "http://mobile.dazuhang.com/1200.html", "http://mobile.dazuhang.com/1201.html", "http://mobile.dazuhang.com/1202.html", "http://mobile.dazuhang.com/1203.html", "http://mobile.dazuhang.com/1205.html", "http://mobile.dazuhang.com/1206.html", "http://mobile.dazuhang.com/1261.html", "http://mobile.dazuhang.com/1313.html", "http://mobile.dazuhang.com/1314.html", "http://mobile.dazuhang.com/1315.html", "http://mobile.dazuhang.com/1327.html", "http://mobile.dazuhang.com/1328.html", "http://mobile.dazuhang.com/1329.html", "http://mobile.dazuhang.com/1330.html", "http://mobile.dazuhang.com/1331.html", "http://mobile.dazuhang.com/1332.html", "http://mobile.dazuhang.com/1333.html", "http://mobile.dazuhang.com/1334.html", "http://mobile.dazuhang.com/1335.html", "http://mobile.dazuhang.com/1337.html", "http://mobile.dazuhang.com/1338.html", "http://mobile.dazuhang.com/1393.html", "http://mobile.dazuhang.com/1431.html", "http://mobile.dazuhang.com/1434.html", "http://mobile.dazuhang.com/1435.html", "http://mobile.dazuhang.com/1444.html", "http://mobile.dazuhang.com/1445.html", "http://mobile.dazuhang.com/1446.html", "http://mobile.dazuhang.com/1536.html", "http://mobile.dazuhang.com/1537.html", "http://mobile.dazuhang.com/361.html", "http://mobile.dazuhang.com/362.html", "http://mobile.dazuhang.com/363.html", "http://mobile.dazuhang.com/400.html", "http://mobile.dazuhang.com/401.html", "http://mobile.dazuhang.com/402.html", "http://mobile.dazuhang.com/403.html", "http://mobile.dazuhang.com/404.html", "http://mobile.dazuhang.com/405.html", "http://mobile.dazuhang.com/406.html", "http://mobile.dazuhang.com/407.html", "http://mobile.dazuhang.com/507.html", "http://mobile.dazuhang.com/1184.html", "http://mobile.dazuhang.com/1185.html", "http://mobile.dazuhang.com/1186.html", "http://mobile.dazuhang.com/1210.html", "http://mobile.dazuhang.com/1211.html", "http://mobile.dazuhang.com/1212.html", "http://mobile.dazuhang.com/1213.html", "http://mobile.dazuhang.com/1214.html", "http://mobile.dazuhang.com/1215.html", "http://mobile.dazuhang.com/1216.html", "http://mobile.dazuhang.com/1217.html", "http://mobile.dazuhang.com/1293.html", "http://mobile.dazuhang.com/1316.html", "http://mobile.dazuhang.com/1317.html", "http://mobile.dazuhang.com/1318.html", "http://mobile.dazuhang.com/1342.html", "http://mobile.dazuhang.com/1343.html", "http://mobile.dazuhang.com/1344.html", "http://mobile.dazuhang.com/1345.html", "http://mobile.dazuhang.com/1346.html", "http://mobile.dazuhang.com/1347.html", "http://mobile.dazuhang.com/1348.html", "http://mobile.dazuhang.com/1349.html", "http://mobile.dazuhang.com/1425.html", "http://mobile.dazuhang.com/1475.html", "http://mobile.dazuhang.com/1476.html", "http://mobile.dazuhang.com/1477.html", "http://mobile.dazuhang.com/366.html", "http://mobile.dazuhang.com/414.html", "http://mobile.dazuhang.com/415.html", "http://mobile.dazuhang.com/1189.html", "http://mobile.dazuhang.com/1224.html", "http://mobile.dazuhang.com/1225.html", "http://mobile.dazuhang.com/1321.html", "http://mobile.dazuhang.com/1356.html", "http://mobile.dazuhang.com/1357.html", "http://mobile.dazuhang.com/1478.html", "http://mobile.dazuhang.com/426.html", "http://mobile.dazuhang.com/427.html", "http://mobile.dazuhang.com/428.html", "http://mobile.dazuhang.com/494.html", "http://mobile.dazuhang.com/495.html", "http://mobile.dazuhang.com/1230.html", "http://mobile.dazuhang.com/1231.html", "http://mobile.dazuhang.com/1232.html", "http://mobile.dazuhang.com/1283.html", "http://mobile.dazuhang.com/1284.html", "http://mobile.dazuhang.com/1362.html", "http://mobile.dazuhang.com/1363.html", "http://mobile.dazuhang.com/1364.html", "http://mobile.dazuhang.com/1415.html", "http://mobile.dazuhang.com/1416.html", "http://mobile.dazuhang.com/364.html", "http://mobile.dazuhang.com/365.html", "http://mobile.dazuhang.com/408.html", "http://mobile.dazuhang.com/409.html", "http://mobile.dazuhang.com/410.html", "http://mobile.dazuhang.com/411.html", "http://mobile.dazuhang.com/412.html", "http://mobile.dazuhang.com/497.html", "http://mobile.dazuhang.com/498.html", "http://mobile.dazuhang.com/504.html", "http://mobile.dazuhang.com/1187.html", "http://mobile.dazuhang.com/1188.html", "http://mobile.dazuhang.com/1218.html", "http://mobile.dazuhang.com/1219.html", "http://mobile.dazuhang.com/1220.html", "http://mobile.dazuhang.com/1221.html", "http://mobile.dazuhang.com/1222.html", "http://mobile.dazuhang.com/1286.html", "http://mobile.dazuhang.com/1287.html", "http://mobile.dazuhang.com/1292.html", "http://mobile.dazuhang.com/1319.html", "http://mobile.dazuhang.com/1320.html", "http://mobile.dazuhang.com/1350.html", "http://mobile.dazuhang.com/1351.html", "http://mobile.dazuhang.com/1352.html", "http://mobile.dazuhang.com/1353.html", "http://mobile.dazuhang.com/1354.html", "http://mobile.dazuhang.com/1418.html", "http://mobile.dazuhang.com/1419.html", "http://mobile.dazuhang.com/1424.html", "http://mobile.dazuhang.com/422.html", "http://mobile.dazuhang.com/423.html", "http://mobile.dazuhang.com/1228.html", "http://mobile.dazuhang.com/1229.html", "http://mobile.dazuhang.com/1360.html", "http://mobile.dazuhang.com/1361.html", "http://mobile.dazuhang.com/370.html", "http://mobile.dazuhang.com/432.html", "http://mobile.dazuhang.com/434.html", "http://mobile.dazuhang.com/435.html", "http://mobile.dazuhang.com/436.html", "http://mobile.dazuhang.com/496.html", "http://mobile.dazuhang.com/1190.html", "http://mobile.dazuhang.com/1236.html", "http://mobile.dazuhang.com/1238.html", "http://mobile.dazuhang.com/1239.html", "http://mobile.dazuhang.com/1240.html", "http://mobile.dazuhang.com/1285.html", "http://mobile.dazuhang.com/1322.html", "http://mobile.dazuhang.com/1368.html", "http://mobile.dazuhang.com/1370.html", "http://mobile.dazuhang.com/1371.html", "http://mobile.dazuhang.com/1372.html", "http://mobile.dazuhang.com/1417.html", "http://mobile.dazuhang.com/484.html", "http://mobile.dazuhang.com/485.html", "http://mobile.dazuhang.com/486.html", "http://mobile.dazuhang.com/487.html", "http://mobile.dazuhang.com/488.html", "http://mobile.dazuhang.com/489.html", "http://mobile.dazuhang.com/490.html", "http://mobile.dazuhang.com/491.html", "http://mobile.dazuhang.com/1273.html", "http://mobile.dazuhang.com/1274.html", "http://mobile.dazuhang.com/1275.html", "http://mobile.dazuhang.com/1276.html", "http://mobile.dazuhang.com/1277.html", "http://mobile.dazuhang.com/1278.html", "http://mobile.dazuhang.com/1279.html", "http://mobile.dazuhang.com/1280.html", "http://mobile.dazuhang.com/1405.html", "http://mobile.dazuhang.com/1406.html", "http://mobile.dazuhang.com/1407.html", "http://mobile.dazuhang.com/1408.html", "http://mobile.dazuhang.com/1409.html", "http://mobile.dazuhang.com/1410.html", "http://mobile.dazuhang.com/1411.html", "http://mobile.dazuhang.com/1412.html", "http://mobile.dazuhang.com/1443.html", "http://mobile.dazuhang.com/1448.html", "http://mobile.dazuhang.com/1460.html", "http://mobile.dazuhang.com/1479.html", "http://mobile.dazuhang.com/1480.html", "http://mobile.dazuhang.com/440.html", "http://mobile.dazuhang.com/441.html", "http://mobile.dazuhang.com/442.html", "http://mobile.dazuhang.com/1244.html", "http://mobile.dazuhang.com/1245.html", "http://mobile.dazuhang.com/1246.html", "http://mobile.dazuhang.com/1376.html", "http://mobile.dazuhang.com/1377.html", "http://mobile.dazuhang.com/1378.html", "http://mobile.dazuhang.com/488.html", "http://mobile.dazuhang.com/489.html", "http://mobile.dazuhang.com/490.html", "http://mobile.dazuhang.com/491.html", "http://mobile.dazuhang.com/1273.html", "http://mobile.dazuhang.com/429.html", "http://mobile.dazuhang.com/1233.html", "http://mobile.dazuhang.com/1365.html", "http://mobile.dazuhang.com/341.html", "http://mobile.dazuhang.com/342.html", "http://mobile.dazuhang.com/344.html", "http://mobile.dazuhang.com/345.html", "http://mobile.dazuhang.com/346.html", "http://mobile.dazuhang.com/348.html", "http://mobile.dazuhang.com/350.html", "http://mobile.dazuhang.com/482.html", "http://mobile.dazuhang.com/483.html", "http://mobile.dazuhang.com/502.html", "http://mobile.dazuhang.com/1167.html", "http://mobile.dazuhang.com/1168.html", "http://mobile.dazuhang.com/1169.html", "http://mobile.dazuhang.com/1170.html", "http://mobile.dazuhang.com/1171.html", "http://mobile.dazuhang.com/1173.html", "http://mobile.dazuhang.com/1174.html", "http://mobile.dazuhang.com/1271.html", "http://mobile.dazuhang.com/1272.html", "http://mobile.dazuhang.com/1290.html", "http://mobile.dazuhang.com/1299.html", "http://mobile.dazuhang.com/1300.html", "http://mobile.dazuhang.com/1301.html", "http://mobile.dazuhang.com/1302.html", "http://mobile.dazuhang.com/1303.html", "http://mobile.dazuhang.com/1304.html", "http://mobile.dazuhang.com/1305.html", "http://mobile.dazuhang.com/1306.html", "http://mobile.dazuhang.com/1403.html", "http://mobile.dazuhang.com/1404.html", "http://mobile.dazuhang.com/1422.html", "http://mobile.dazuhang.com/371.html", "http://mobile.dazuhang.com/446.html", "http://mobile.dazuhang.com/447.html", "http://mobile.dazuhang.com/501.html", "http://mobile.dazuhang.com/508.html", "http://mobile.dazuhang.com/1191.html", "http://mobile.dazuhang.com/1248.html", "http://mobile.dazuhang.com/1249.html", "http://mobile.dazuhang.com/1289.html", "http://mobile.dazuhang.com/1294.html", "http://mobile.dazuhang.com/1323.html", "http://mobile.dazuhang.com/1380.html", "http://mobile.dazuhang.com/1381.html", "http://mobile.dazuhang.com/1421.html", "http://mobile.dazuhang.com/1426.html", "http://mobile.dazuhang.com/450.html", "http://mobile.dazuhang.com/451.html", "http://mobile.dazuhang.com/452.html", "http://mobile.dazuhang.com/453.html", "http://mobile.dazuhang.com/503.html", "http://mobile.dazuhang.com/1250.html", "http://mobile.dazuhang.com/1251.html", "http://mobile.dazuhang.com/1252.html", "http://mobile.dazuhang.com/1253.html", "http://mobile.dazuhang.com/1254.html", "http://mobile.dazuhang.com/1291.html", "http://mobile.dazuhang.com/1382.html", "http://mobile.dazuhang.com/1383.html", "http://mobile.dazuhang.com/1384.html", "http://mobile.dazuhang.com/1385.html", "http://mobile.dazuhang.com/1386.html", "http://mobile.dazuhang.com/1423.html", "http://mobile.dazuhang.com/1432.html", "http://mobile.dazuhang.com/1441.html", "http://mobile.dazuhang.com/372.html", "http://mobile.dazuhang.com/1192.html", "http://mobile.dazuhang.com/1324.html", "http://mobile.dazuhang.com/1440.html", "http://mobile.dazuhang.com/455.html", "http://mobile.dazuhang.com/459.html", "http://mobile.dazuhang.com/492.html", "http://mobile.dazuhang.com/493.html", "http://mobile.dazuhang.com/1255.html", "http://mobile.dazuhang.com/1256.html", "http://mobile.dazuhang.com/1281.html", "http://mobile.dazuhang.com/1282.html", "http://mobile.dazuhang.com/1387.html", "http://mobile.dazuhang.com/1388.html", "http://mobile.dazuhang.com/1413.html", "http://mobile.dazuhang.com/1414.html", "http://mobile.dazuhang.com/374.html", "http://mobile.dazuhang.com/463.html", "http://mobile.dazuhang.com/465.html", "http://mobile.dazuhang.com/467.html", "http://mobile.dazuhang.com/468.html", "http://mobile.dazuhang.com/509.html", "http://mobile.dazuhang.com/510.html", "http://mobile.dazuhang.com/1194.html", "http://mobile.dazuhang.com/1257.html", "http://mobile.dazuhang.com/1258.html", "http://mobile.dazuhang.com/1259.html", "http://mobile.dazuhang.com/1260.html", "http://mobile.dazuhang.com/1295.html", "http://mobile.dazuhang.com/1296.html", "http://mobile.dazuhang.com/1326.html", "http://mobile.dazuhang.com/1389.html", "http://mobile.dazuhang.com/1390.html", "http://mobile.dazuhang.com/1391.html", "http://mobile.dazuhang.com/1392.html", "http://mobile.dazuhang.com/1427.html", "http://mobile.dazuhang.com/1428.html", "http://mobile.dazuhang.com/437.html", "http://mobile.dazuhang.com/438.html", "http://mobile.dazuhang.com/439.html", "http://mobile.dazuhang.com/1193.html", "http://mobile.dazuhang.com/1241.html", "http://mobile.dazuhang.com/1242.html", "http://mobile.dazuhang.com/1243.html", "http://mobile.dazuhang.com/1325.html", "http://mobile.dazuhang.com/1373.html", "http://mobile.dazuhang.com/1374.html", "http://mobile.dazuhang.com/1375.html", "http://mobile.dazuhang.com/430.html", "http://mobile.dazuhang.com/431.html", "http://mobile.dazuhang.com/1234.html", "http://mobile.dazuhang.com/1235.html", "http://mobile.dazuhang.com/1366.html", "http://mobile.dazuhang.com/1367.html", "http://mobile.dazuhang.com/1456.html", "http://mobile.dazuhang.com/1267.html", "http://mobile.dazuhang.com/1399.html", "http://mobile.dazuhang.com/1442.html", "http://mobile.dazuhang.com/470.html", "http://mobile.dazuhang.com/471.html", "http://mobile.dazuhang.com/473.html", "http://mobile.dazuhang.com/474.html", "http://mobile.dazuhang.com/476.html", "http://mobile.dazuhang.com/477.html", "http://mobile.dazuhang.com/478.html", "http://mobile.dazuhang.com/1165.html", "http://mobile.dazuhang.com/1262.html", "http://mobile.dazuhang.com/1263.html", "http://mobile.dazuhang.com/1265.html", "http://mobile.dazuhang.com/1266.html", "http://mobile.dazuhang.com/1268.html", "http://mobile.dazuhang.com/1269.html", "http://mobile.dazuhang.com/1270.html", "http://mobile.dazuhang.com/1298.html", "http://mobile.dazuhang.com/1394.html", "http://mobile.dazuhang.com/1395.html", "http://mobile.dazuhang.com/1397.html", "http://mobile.dazuhang.com/1398.html", "http://mobile.dazuhang.com/1400.html", "http://mobile.dazuhang.com/1401.html", "http://mobile.dazuhang.com/1402.html", "http://mobile.dazuhang.com/1430.html", "http://mobile.dazuhang.com/1449.html", "http://mobile.dazuhang.com/1450.html", "http://mobile.dazuhang.com/1451.html",
        );
        $api = 'http://data.zz.baidu.com/urls?site=mobile.dazuhang.com&token=kgiEfPVnGtD9QdIH';
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        echo $result;
    }
}
