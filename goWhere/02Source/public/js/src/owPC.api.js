/**
 * Created by zds on 2016/6/21.
 */
var owDomain = document.domain;//document.domain

var owAPI = {
  "changePsd": 'http://' + owDomain + '/member/changePassword',          //修改密码
  "changeEmail": 'http://' + owDomain + '/member/changeEmail',           //修改邮箱
  "getOldPhoneSMS": 'http://' + owDomain + '/auth/captcha/getMySMSCode',  //获取旧手机验证码
  "changeOldPhone": 'http://' + owDomain + '/member/changePhone/1',       //修改手机第一步
  "getNewPhoneSMS": 'http://' + owDomain + '/auth/captcha/getSMSCode',    //获取新手机验证码
  "changeNewPhone": 'http://' + owDomain + '/member/changePhone/2',       //修改手机第二步
  "regEmail": 'http://' + owDomain + '/auth/register/2',                 //邮箱注册
  "login": 'http://' + owDomain + '/auth/login',                         //登录
  "cancelOrder": 'http://' + owDomain + '/member/order/cancel',           //取消订单
  "oneStepService": 'http://' + owDomain + '/mice/addneedsall'             //一站服务
};
