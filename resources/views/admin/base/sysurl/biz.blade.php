      <table border="0" cellpadding="5" cellspacing="0" class="r_con_table">
        <thead>
          <tr>
            <td width="10%" nowrap="nowrap">序号</td>
            <td width="20%" nowrap="nowrap">名称</td>
            <td width="60%" nowrap="nowrap" class="last">Url</td>
          </tr>
        </thead>
        <tbody>
          <?php
            $bizs = \App\Models\Biz::all();
          ?>
          @foreach($bizs as $k => $v)
              <tr>
                <td nowrap="nowrap">{{$k+1}}</td>
                <td nowrap="nowrap">{{$v->Biz_Name}}</td>
                <td nowrap="nowrap" class="left last">
                    http://{{$rulreal}}/api/biz/{{$v["Biz_ID"]}}/
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>