<?php
/**
 * Created by xin.
 * Date: 2018/11/29
 * Time: 3:37 PM
 */

namespace App\Libraries;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use JeroenNoten\LaravelAdminLte\Menu\Builder;

/**
 * 修复AdminLTE主题菜单带上参数后不显示激活状态新增
 * Class AdminLteActiveFilter
 * @package App\Libraries
 */
class AdminLteActiveFilter implements FilterInterface
{
    private $activeChecker;

    public function __construct(AdminLteActiveChecker $activeChecker)
    {
        $this->activeChecker = $activeChecker;
    }

    public function transform($item, Builder $builder)
    {
        if (! isset($item['header'])) {
            $item['active'] = $this->activeChecker->isActive($item);
        }

        return $item;
    }
}