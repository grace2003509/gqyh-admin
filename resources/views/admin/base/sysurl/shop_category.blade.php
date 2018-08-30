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
                <td nowrap="nowrap" class="left last">http://{{$rulreal}}/api/shop/wzw/</td>
            </tr>
            <tr>
                <td nowrap="nowrap">2</td>
                <td nowrap="nowrap">全部分类</td>
                <td nowrap="nowrap" class="left last">http://{{$rulreal}}/api/shop/allcategory/</td>
            </tr>
              <?php
                $list_column = \App\Models\ShopCategory::orderBy('Category_ID', 'asc')->get();
              ?>
            @foreach($list_column as $k => $v)
            <tr>
                <td nowrap="nowrap">{{$k+3}}</td>
                <td nowrap="nowrap">{{$v["Category_Name"]}}</td>
                <td nowrap="nowrap" class="left last">
                    http://{{$rulreal}}/api/shop/category/{{$v["Category_ID"]}}/
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>