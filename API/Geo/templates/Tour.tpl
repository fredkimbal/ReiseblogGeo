{include file="TourHeadAndMap.tpl" title=$title}

        <div class="w3-row">
            <table class="w3-table w3-striped w3-border table_tour scroll">
                <thead>
                <tr >
                    <th class="th1 th_tour">Datum</th>
                    {if $velo == true}
                        <th class="th2 th_tour">Distanz</th>                   
                        <th class="th3 th_tour"><i class="fa fa-line-chart " aria-hidden="true"></i></th>
                        
                    {/if}
                    <th class="th4 th_tour"><i class="fa fa-map-marker" aria-hidden="true"></i></th>
                </tr>

                </thead>
                <tbody >
                {foreach from=$stages item=stage}
                    <tr>
                        <td class="td1">
                            {$stage['Caption']}
                        </td>

                        {if $velo == true}
                        <td class="td2">
                            {$stage['Distance'] / 1000} km
                        </td>                        
                            <td class="td3">
                                <a href="#" class="showLineChartButton" data-id="{$stage['ID']}" data-caption="{$stage['Caption']}">
                                    <i class="fa fa-line-chart " aria-hidden="true"></i>
                                </a>
                            </td>
                        {/if}
                        <td class="td4">
                            <a href="#" class="showMapButton" data-id="{$stage['ID']}">
                                <i class="fa fa-map-marker " aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>

                {/foreach}
                </tbody>
            </table>
        </div>
    </div>


    <div id="elevationchartmodal" class="w3-modal" width="500">
        <div class="w3-modal-content" style="width:500px">
            <div class="w3-container">
                <span id="closemodalbutton" class="w3-button w3-display-topright">&times;</span>
                <h4>Höhenprofil <span id="trackcaption"></span></h4>
                <img id="elevationchart" src="" width="100%">
            </div>
        </div>

    </div>
    <script>
        $( document ).ready(function() {
            showMap({$zoom});
            $(".showMapButton").click((e)=>{
                var id = $(e.currentTarget).data('id');
                centerMapToLastPoint(id);
            });

            $(".showLineChartButton").click((e)=>{
                var id = $(e.currentTarget).data('id');
                $("#trackcaption").html($(e.currentTarget).data('caption'));
                $("#elevationchart").attr("src","https://luanaundandy.ch/ReiseblogGeo/REST/api/v1/Geo/ElevationChart/"+id);
                $("#elevationchartmodal").show();
            });

            $("#closemodalbutton").click(()=>{
                $("#elevationchartmodal").hide();
            })
            map.on("moveend", () => {
                loadTracksInBound({$tourPart});
            });
            loadTracksInBound({$tourPart});            
        });

    </script>
</body>
</html>
