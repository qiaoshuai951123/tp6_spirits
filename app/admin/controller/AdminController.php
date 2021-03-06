<?php
namespace app\admin\controller;

use app\admin\controller\base\CommonController;
use think\exception\ValidateException;
use think\facade\Db;
use think\facade\Filesystem;

class AdminController extends CommonController{

    public function index(){
        return view('index',[

        ]);
    }
    /*
     * 列表数据
     */
    public function adminList(){
        try {
            $params = request()->get();
            if (!isset($params['page']) || $params['page'] <= 0){
                $params['page'] = 1;
            }
            if (!isset($params['pageSize']) || $params['pageSize'] <= 0){
                $params['page'] = 10;
            }
            $totalCount = Db::name('admin')->count();
            $lastPage = ceil($totalCount / $params['pageSize']);
            if ($params['page'] > $lastPage && $lastPage > 0){
                $params['page'] = $lastPage;
            }
            $nextLimit = ($params['page']-1) * $params['pageSize'];
            $admins = Db::name('admin')->order('create_time','desc')->limit($nextLimit,$params['pageSize'])->select();
            if ($admins){
                return json(['code'=>0,'msg'=>'获取成功','count'=>$totalCount,'data'=>$admins]);
            }else{
                return json(['code'=>-1,'msg'=>'获取失败','count'=>$totalCount,'data'=>$admins]);
            }
        }catch (\Exception $e){
            return json(['msg'=>'error','code'=>-1]);
        }
    }

    /**
     * 添加
     */
    public function add(){
        if (request()->isPost()){
            $params = array_filter(request()->post());
            if (!isset($params['user_status']) || $params['user_status'] == 0){
                $params['user_status'] = 0;
            }
            if (isset($params['user_pass']) && !empty($params['user_pass'])) {
                $params['user_pass'] = password_hash($params['user_pass'], PASSWORD_BCRYPT);
            }
            $params['create_time'] = date('Y-m-d H:i:s');
            $field = Db::name('admin')->where(['user_name'=>$params['user_name']])->find();
            if ($field) return json(['msg'=>'该用户名已存在','code'=>-1]);
            return (Db::name('admin')->save($params)) ? json(['msg'=>'保存成功','code'=>0]) : json(['msg'=>'保存失败','code'=>-1]);
        }else {
            return view('add');
        }
    }

    public function edit(){
        if (request()->isPost()){
            $params = array_filter(request()->post());
            if (!isset($params['user_status']) || $params['user_status'] == 0){
                $params['user_status'] = 0;
            }
            if (isset($params['user_pass']) && !empty($params['user_pass'])) {
                $params['user_pass'] = password_hash($params['user_pass'], PASSWORD_BCRYPT);
            }
            $params['update_time'] = date('Y-m-d H:i:s');
            return (Db::name('admin')->update($params)) ? json(['msg'=>'保存成功','code'=>0]) : json(['msg'=>'保存失败','code'=>-1]);
        }else {
            $params = request()->get();
            $field = Db::name('admin')->where(['id'=>$params['id']])->find();
            return view('edit',[
                'field'=>$field
            ]);
        }
    }

    //删除
    public function del(){
        try{
            $params = request()->get();
            if (Db::name('admin')->where(['id'=>$params['id']])->delete()){
                return json(['msg'=>'ok','code'=>0]);
            }else{
                return json(['mssg'=>'error','code'=>-1,'message'=>'删除失败']);
            }
        }catch (\Exception $e){
            return json(['mssg'=>'error','code'=>-1,'message'=>$e->getMessage()]);
        }
    }

    /**
     * 图片上传
     * @return \think\response\Json
     */
    public function uploadImg(){
        try{
            if (request()->isPost()) {
                // 获取表单上传文件 例如上传了001.jpg
                $file = request()->file('file');
                try {
                    validate([
                        'file'=>[
                            'fileSize' => 52428800,
                            'fileExt' => 'jpg,jpeg,png,gif',
                            'fileMime' => 'image/jpeg,image/png,image/gif', //这个一定要加上，很重要我认为！
                        ]
                    ])->check(['file' => $file]);
                    //获取磁盘保存目录
                    $disk = Filesystem::getDiskConfig('public');
                    //保存图片到本地服务器
                    $savename = Filesystem::disk('public')->putFile( 'admin', $file);
                    return json(['code'=>0,'msg'=>'上传成功','src'=>$disk['url'].'/'.$savename]);
                } catch (ValidateException $v) {
                    return json(['code'=>-1,'msg'=>$v->getMessage()]);
                }
            }else{
                return json(['code'=>-1,'msg'=>'请求错误']);
            }
        }catch (\Exception $e){
            return json(['code'=>-1,'msg'=>$e->getMessage()]);
        }
    }

}