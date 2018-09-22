<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-09-08
 * Time: 16:20
 */

namespace app\common\model;


use think\Model;

class Order extends Model
{

    protected function initialize()
    {
        parent::initialize();
    }

    /**
     * 订单商品处理
     */
    public function orderSolve($product_list)
    {
        if(!$product_list){
            return false;
        }

        foreach ($product_list as $item){
            //军团商品处理
            $hgp = \model("HeaderGroupProduct")->where("id", $item['header_product_id'])->find();
            $hgp->save(['sell_num'=>$hgp['sell_num']+$item['num'], "remain"=>$hgp['remain']-$item['num']]);
            //团购商品处理
            \model('GroupProduct')->where('id', $item['product_id'])->setInc('sell_num', $item['num']);
        }

        //团长佣金计算

        //城主佣金计算

        return true;
    }

    /**
     * 获取当前团购下订单数量
     */
    public function getLastNum($group_id)
    {
        $num = $this->where("group_id", $group_id)->count();
        return $num+1;
    }

}