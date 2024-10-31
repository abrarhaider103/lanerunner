<div class="col-xl-6 mb-5 mb-xl-6">
    <!--begin::Timeline widget 3-->
    <div class="news h-100">
        <div class="card h-md-100">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark">LATEST NEWS</span>
                </h3>
                <?php
                $startDate = strtotime('-2 days'); // Today minus 3 days
                $endDate = strtotime('+4 days'); // Today plus 4 days
                $hoy = date('d');
                ?>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-7 px-0 overflow-auto" style="height:280px;">
            <?php 
                                                        $sql = "select * from latest_news where 1";
                                                        $res = $quote->getThis1($sql);
                                                        echo urldecode($res->latest_news_text);
                                                    ?>
            </div>
            <!--end: Card Body-->
        </div>
    </div>
    <!--end::Timeline widget 3-->
</div>


<div class="modal fade" tabindex="-1" id="expanded_news_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Today's News</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-1"></span>
                </div>
            </div>
            <div class="modal-body">
                <div class="mb-0">
                    <p id="expanded_news_section"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>