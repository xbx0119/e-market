<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
         $this->display();
     }
     public function Login(){
          $this->display();
     }
       //
     public function register(){
        $this->display();
     }
     public function findpwd(){
        $this->display();
     }
     //

     //----------具体操作-----------------
     //检查用户是否存在
     public function check_user(){
      if($_GET){
        $zd=I('get.zd');
        $table="user";
        $con=I('get.con');
        $this->check($zd,$table,$con);
      }
     }
     //注册  
     public function record(){
       // if($_POST){
        //$table='business';//商家注册
        $table='user';//用户注册
        $data['username']="username";
        $data['password']="password";
        $data['email']="email"; 
        $data['tel']="tel";
     // }
        $m=M($table);
        if($m->add($data)){
        	echo "已存在";
        }else{
        	echo "未使用";
        }
     }
     //判断该字段是否存在
      public function check($zd,$table,$con){
        // $zd="username";
        // $table="user"; //用户验证
        // //$table='business';//商家验证
        // $con="username";
         $where[$zd]=$con;
         $m=M($table);
         $num=$m->where($where)->find();
         // var_dump($num);
         if($num){
         	echo "已存在";
         }else{
         	echo "未使用";
         }
      }
      //用户登录判断
      public function do_login(){
         $where['user']="username";
         $where['password']="password";
         $m=M('user');
         $num=$m->where($where)->find();
         if($num){
         	echo "success";
         }else{
         	echo "failure";
         }
      }
     //发送密码至邮箱
     public function sendpwd(){
   //   $yx='shq2896935608@163.com'; 
      $yx="2896935608@qq.com";
      $this->checkemail($yx);
      $pt='电子商城密码找回';
      $FromUser='电子商城';
      $num=$this->create_md();
      $con='您的密码是'.$num;
         import('Vendor.Mail');
         SendMail($yx,$pt,$con,$FromUser);
      $_SESSION['yx']=$yx;
      $_SESSION['md']=$num;
     }
    //随机生成密码
     public  function create_md($pw_length = 6){
          $randaccount = '';
          for ($i = 0; $i < $pw_length; $i++){
               $randaccount .= chr(mt_rand(49, 57));
          }
        return $randaccount;
     }
     //检验邮箱
     public function checkyx($yx){
         $map['email']=$yx;
         $m=M('user');
         if($m->where($map)->find()){

         }else{
            echo "没有此邮箱，请检查或重新注册";
            exit;
         }
     }
     //检查验证码
     public function checkyzm(){
         $yzm=I('get.yzm');
         if($yzm==$_SESSION['md']){
            unset($_SESSION['md']);
            echo "1";
         }else{
            echo "验证码不正确，请重试";
         }
     }
     //重置密码
     public function repwd(){
         $data['password']=I('post.pwd');
         $m=M('user');
         $str=$m->where($map)->find();
         if($str){
             $m->where("aid=".$str['aid'])->save($data);
         }else{
             echo "重置密码，请重试";
         }
     }
 }