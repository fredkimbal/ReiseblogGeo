{include file="TourHeadAndMap.tpl" title=$title}


    <div class="w3-row">
        <table class="w3-table w3-striped w3-border">

            <tr>
                <th>Datum</th>
                <th>Distanz</th>
                <th>&nbsp;</th>
                
            </tr>

            {foreach from=$stages item=stage}
                <tr>
                    <td>
                        {$stage['TrackDate']}
                    </td>
                    <td>
                        {$stage['Distance'] / 1000} km
                    </td>
                    <td>
                        <a href="#" class="showMapButton" data-id="{$stage['ID']}"><i class="fa fa-map " aria-hidden="true"></i></a>                    </td>
                </tr>

            {/foreach}

        </table>
        
    
    </div>

</div>
    <script>

        $( document ).ready(function() {
            showMap();

            $(".showMapButton").click((e)=>{
                var id = $(e.currentTarget).data('id');
                LoadSingleTrack(id);
            });

        });
    </script>

</body>


</html>
