<script src="http://code.jquery.com/jquery-2.0.0.js"></script>
<script>
    $(document).ready(function (){
        scriptController.init();
    });

    var scriptController = {
        selectedId: {
            1: null,
            2: null
        },
        hoveredId: null,
        select: function(id, level){
            if(level == 1)
                this.selectPoint(id, level);

            this.selectCell(id, level);
            this.selectedId[level] = id;
        },
        hover: function(id, value, level){
            if(value) {
                $('#point_'+id).addClass('point_hover');
                $('#cell_'+id).addClass('cell_hover');
                this.hoveredId = id;
                if(this.selectedId[level]) $('#point_'+this.selectedId[level]).removeClass('point_selected');
            } else {
                if(this.hoveredId) {
                    $('#point_'+id).removeClass('point_hover');
                    $('#cell_'+id).removeClass('cell_hover');
                }
                if(this.selectedId[level]) $('#point_'+this.selectedId[level]).addClass('point_selected');
            }
        },
        selectPoint: function(id, level){
            if(this.selectedId[level])
                $('#point_'+this.selectedId[level]).removeClass('point_selected');
            $('#point_'+id).addClass('point_selected');
        },
        selectCell: function(id, level) {
            if(this.selectedId[level]) {
                $('#cell_' + this.selectedId[level]).removeClass('selected');
            }
            $('#cell_' + id).addClass('selected');

            $('#col_' + (level+1)+" a").hide();
            $('#col_' + (level+2)+" a").hide();
            $('#col_' + (level+1)+" a.child_" + id).show();
        },
        init: function(){
            $('#col_1 a').mouseenter(function(){ scriptController.hover(getIdFromCol(this), true, 1);})
                .mouseleave( function(){scriptController.hover(getIdFromCol(this), false, 1);})
                .on("click",function(){scriptController.select(getIdFromCol(this), 1); });

            $('#col_2 a').on("click",function(){scriptController.select(getIdFromCol(this), 2); }).hide();

            //$('#col_3 a').on("click",function(){scriptController.select(getIdFromCol(this), 1); });

            $('.point').on('click', function(){scriptController.select(getIdFromPoint(this), 1);})
                .mouseenter(function(){scriptController.hover(getIdFromPoint(this), true, 1);})
                .mouseleave(function(){scriptController.hover(getIdFromPoint(this), false, 1);
                });

            $('#col_3 a').hide();
        }
    }


    function getIdFromPoint(obj) {
        return $(obj).attr('id').replace('point_', '');
    }
    function getIdFromCol(obj) {
        return $(obj).attr('id').replace('cell_', '');
    }

</script>