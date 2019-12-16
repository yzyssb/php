<?php

namespace app\push\controller;

use Workerman\Worker;

use Workerman\Lib\Timer;

use Workerman\Connection\AsyncTcpConnection;

class WorkerTest

{

    private $connections;

    private $connection_to_ws;

    public function index()

    {

        // $connections = array(); 

        $socket = new Worker('websocket://0.0.0.0:2346');

        // 设置transport开启ssl，websocket+ssl即wss

        // $socket->transport = 'ssl';

        // 启动1个进程对外提供服务  

        $socket->count = 1;

        //给这个进程设置一个array（）

        // 当有客户端连接时

        $socket->onConnect = function($connection)

        {

            var_dump(count($this->connections));

            $connection->send("lianjie");

            $this->connections[$connection->id]=$connection;

        };

        // 当有客户端连接时

        $socket->onMessage = function($connection,$data)

        {

            // var_dump($data);

            // var_dump(json_decode($data));

            $jdata = json_decode($data);

            if(isset($jdata->tem))

            {

                foreach($this->connections as $con){

                    if(isset($con->endno)&&isset($jdata->endno)&&$con->endno==$jdata->endno){

                        $con->send($jdata->tem);

                    }

                }

            }

            else

            {

                $connection->send("数据已接受");

                $connection->endno=$jdata->endno;

                $this->connections[$connection->id]=$connection;

            }

        };

        // 当有客户端连接断开时

        $socket->onClose = function($connection)

        {

            if(isset($connection->id))

            {

                // 连接断开时删除映射

                unset($this->connections[$connection->id]);

            }

        };

        $tcp = new Worker('tcp://0.0.0.0:8282');

        $tcp->onMessage = function($connection, $data)

        {

            if(is_null($this->connection_to_ws))

            {

                var_dump('connect');

                $this->connection_to_ws = new AsyncTcpConnection('ws://119.29.170.92:2346');

                $this->connection_to_ws->connect();

            }

            $this->connection_to_ws->send($data);

            // var_dump(count($this->connections));

            //  foreach($this->connections as $con){

            //      if($con->endno==json_decode($data)->endno){

            //          $con->send(json_decode($data)->tem);

            //      }

            //  }

            };

        // 运行worker  

        Worker::runAll();

        }

}