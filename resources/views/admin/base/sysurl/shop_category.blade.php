      <table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
        <thead>
          <tr>
            <td width="10%" nowrap="nowrap">序号</td>
            <td width="20%" nowrap="nowrap">名称</td>
            <td width="60%" nowrap="nowrap" class="last">Url</td>
          </tr>
        </thead>
        <tbody>
		<tr>
            <td nowrap="nowrap">1</td>
            <td nowrap="nowrap">首页</td>
            <td nowrap="nowrap" class="left last">http://<?php echo $rulreal ?>/api/<?php echo USERSID ?>/shop/union/?love</td>
          </tr>
          <tr>
            <td nowrap="nowrap">2</td>
            <td nowrap="nowrap">购物</td>
            <td nowrap="nowrap" class="left last">http://<?php echo $rulreal ?>/api/<?php echo USERSID ?>/shop/wzw/</td>
          </tr>
		   <tr>
            <td nowrap="nowrap">3</td>
            <td nowrap="nowrap">全部分类</td>
            <td nowrap="nowrap" class="left last">http://<?php echo $rulreal ?>/api/<?php echo USERSID ?>/shop/allcategory/?love</td>
          </tr>
          <?php
            $list_column = \App\Models\ShopCategory::orderBy('Category_ID', 'asc')->get();
            foreach($list_column as $k => $v){
		  ?>
          <tr>
            <td nowrap="nowrap"><?php echo $k+4;?></td>
            <td nowrap="nowrap"><?php echo $v["Category_Name"];?></td>
            <td nowrap="nowrap" class="left last">
            	http://<?php echo $rulreal ?>/api/<?php echo USERSID ?>/shop/category/<?php echo $v["Category_ID"];?>/
            </td>
          </tr>
          <?php
            }
		  ?>
        </tbody>
      </table>