<style type="text/css">
	.table_container {float:left; width:100%; max-width:100%;}
	#face_selector .face_image {
        width: 390px;
        height: 560px;
        background-image: url("/wp-content/themes/Kamea/wskazania_source/img/face.jpg");
        float: left;
        position: relative;
    }

	#face_selector .point {
        position: absolute;
        background-image: url("/wp-content/themes/Kamea/wskazania_source/img/point_off.png");
        width: 30px;
        height: 30px;
    }
	#face_selector .point:hover, #face_selector .point_hover, #face_selector .point_selected{
        background-image: url("/wp-content/themes/Kamea/wskazania_source/img/point_on.png");
    }
	#face_selector.table {
		width: 100%;
		float: left;
	}
	#face_selector.table th.face_th {border-top:none; padding:0;}
	#face_selector.table td {
		vertical-align: top;
		border-top: none;
	}
	#face_selector.table td {padding:0;}
	#face_selector.table .col {
        border-top:none;
        width:200px;
	    background-color:#F1F4FB;
        padding:0;
    }
	#face_selector.table .col .line-top {display:inline-block; width:90%; margin:0 5%; height:1px; border-top:1px solid #CBCFD8; vertical-align:top;}
	#face_selector.table .table_th {
	    text-align:left;
        vertical-align: middle;
        padding:10px 20px;
        border-top: none;
        font-size: 22px;
        font-weight:300;
        color: #338EBB;
        background-color: #F1F4FB;
    }
	#face_selector.table .td_separator {width: 10px; padding: 0; border: none;}
	#face_selector.table .col a {text-decoration: none; padding: 10px 10px 10px 20px; width: 100%; float: left;}
	#face_selector.table .col a:hover, .cell_hover,
	#face_selector.table .col a.selected {background-color: #51C1E9; color: #D8F7FF}
	#face_selector.table .table_th.separator, #face_selector.table #col_1,#face_selector.table #col_2 {border-right:5px solid #FFFFFF;}
	#face_selector.table #col_2,#face_selector.table #col_3 {font-size: 13px;}

	#face_selector .face_border_bottom {background-color: #51C1E9; height: 20px; padding: 0;}
    .desc_bottom { width:100%; text-align: center; float:left; margin-top: 70px; }
	.desc_bottom .desc_row {width: 100%; float: left; line-height: 1.2}
    .desc_bottom .desc1 {font-size: 24px; color: #338EBB;}
    .desc_bottom .desc2 {font-size: 42px; color: #06C3E1}
    .desc_bottom .desc3 {font-size: 52px; color: #0086B5; height: 100%; vertical-align:middle;}
	@media (max-width:900px){
		.table_container {max-width:900px; min-width:200px; overflow-x:auto;}
		#face_selector.table .col {min-width:180px;}
		#face_selector.table #face_image, #face_selector.table .face_th, #face_selector.table .face_border_bottom {display:none;}
		#face_selector.table .face_border_bottom {height:0; background:none;}
	}
</style>