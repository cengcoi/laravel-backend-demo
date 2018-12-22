<?php
/**
 * Created by xin.
 * Date: 2018/11/29
 * Time: 3:39 PM
 */

namespace App\Libraries;


use JeroenNoten\LaravelAdminLte\Menu\ActiveChecker;

/**
 * 修复AdminLTE主题菜单带上参数后不显示激活状态新增
 * Class AdminLteActiveChecker
 * @package App\Libraries
 */
class AdminLteActiveChecker extends ActiveChecker
{
    protected function checkSub($url)
    {
        return $this->checkPattern($url.'/*') or $this->checkPattern($url.'?*');
    }
}