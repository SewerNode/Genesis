<div style="text-align: center; margin-bottom: 32px">Wybierz interesującą Cię część ciała, żeby zobaczyć najczęstsze problemy i sposoby by im zaradzić.</div>
<div class="table_container">
<table id="face_selector" class="table" cellpadding="0" cellspacing="0">
    <tr>
        <th rowspan="2" class="face_th">
            <div id="face_image" class="face_image">
                <?php foreach ($col1 as $row):?>
                    <a href="javascript:;"
                       class = "point"
                       title="<?php echo $row['name'];?>"
                       id="point_<?php echo $row['id'];?>"
                       style="left: <?php echo $row['point']['x'];?>px; top:<?php echo $row['point']['y'];?>px;">
                    </a>
                <?php endforeach;?>
            </div>
        </th>
        <th class="table_th separator">CZĘŚC CIAŁA</th>

        <th class="table_th separator">PROBLEM</th>

        <th class="table_th">ZABIEG</th></tr>
    <tr>
        <td id="col_1" class="col separator">
	        <span class="line-top"></span>
            <?php foreach ($col1 as $row):?>
                <a href="javascript:;" id = "cell_<?php echo $row['id'];?>"><?php echo $row['name'];?></a>
            <?php endforeach;?>
        </td>
        <td id="col_2" class="col separator">
	        <span class="line-top"></span>
            <?php foreach ($col2 as $row):?>
                    <a href="javascript:;"
                       id = "cell_<?php echo $row['id'];?>"
                       style="display: none"
                       class="child_<?php echo $row['parent'];?>">
	                    <?php echo $row['name'];?>
                    </a>
            <?php endforeach;?>
        </td>
        <td id="col_3" class="col">
	        <span class="line-top"></span>
            <?php foreach ($col3 as $row):?>
                <a href="<?php echo $row['href'];?>"
                    id = "cell_<?php echo $row['id'];?>"
                    style="display: none"
                    class="child_<?php echo $row['parent'];?>">
                    <?php echo $row['name'];?>
                </a>
            <?php endforeach;?>
        </td>
    </tr>
    <tr>
        <td class="face_border_bottom">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
</div>
<div class="desc_bottom">
    <span class="desc1 desc_row">Nie wiesz który zabieg będzie dla Ciebie najodpowiedniejszy?</span>
    <span class="desc2 desc_row">SKONSULTUJ SIĘ Z NAMI TELEFONICZNIE</span>
    <span class="desc3 desc_row"><img style="margin-right: 10px;vertical-align: middle;" src="/wp-content/themes/Kamea/wskazania_source/img/phone.png" />55 611 41 11</span>
</div>
