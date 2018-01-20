<div class="fluid-container bg-whiting">
    <div class="container">
        <!-- END NAVIGATION -->
        <!-- STATR SUBJECT COMPETITIONS -->
        <div class="fluid-container">
            <div class="container">
                <div class="subject-competitions text-center">
                    <img src="[VARURL]publicuser/style1/images/subject-ribbon.png" />
        <!--            <img src="[VARURL]images/icons/camera-icon.png" />-->
                    <div class="subject-match-head">
                        <span>مسابقات [VARKINDCOMP]</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SUBJECT COMPETITIONS -->

        <!-- START COMPETITIONS -->
        <div class="container">
            <div class="row marginbottom40">
                [VARCOMPLIST]
                [VARWHICHCOMP]
            </div>
            <div id="paging" class="load-more-image">
                <!--<input type="hidden" name="whichpg" id="whichpg" value="1">-->
                <button type="button" name="more" id="more" class="more-img" >
                    <img src="[VARURL]images/icons/refresh.png" />
                </button>
            </div>
            <div id="waiting" class="none load-more-image">
                <button type="button" name="more" id="more" class="load-img" >
                    <img src="[VARURL]images/icons/refresh-wait.png" />
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END COMPETITIONS -->
<!-- JS link -->
<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/competitions.js"></script>
<script type="text/javascript" src="js/index.js"></script>
