<a href="#" (click)="globItemClick()">Yo</a>
<!--<div class="col-md-2">-->
<!--    <button type="button" onClick="return showCanvas()" class="btn btn-block btn-primary">Get Started</button>-->
<!--</div>-->
<!--</div>-->


<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div id="myCanvasContainer">
            <canvas width="200" height="300" id="myCanvas" style="margin-left: 20%;">
                <p>Anything in here will be replaced on browsers that support the canvas element</p>
                <ul>
                    <?php
                    if (isset($keywords) && count($keywords) > 0) {
                        foreach ($keywords as $keyword) {
                            ?>
                            
                            <li><a href="#" (click)="globItemClick()" >
        <?php echo $keyword->keyword; ?>
                                </a>
                            </li>
                        <?php
                        }
                    }
                    ?>
                </ul>
            </canvas>
        </div>

    </div>
</div>








<script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
crossorigin="anonymous"></script>


<script type="text/javascript" src="<?php echo Request::$BASE_URL; ?>js/tagcanvas.js"></script>
<script type="text/javascript">
                                    if (!$('#myCanvas').tagcanvas({
                                        textColour: '#000000',
                                        outlineThickness: 1,
                                        maxSpeed: 0.03,
                                        depth: 0.75
                                    })) {
                                        // TagCanvas failed to load
                                        $('#myCanvasContainer').show();
                                    }
                                    // your other jQuery stuff here...

                                // function showCanvas(){
                                //     $('#myCanvasContainer').show('slow');
                                // }
                                // window.onload = showCanvas;


</script>
</body>
</html>


