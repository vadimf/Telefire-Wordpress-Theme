<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">כתב כמויות</h5>

                <a href="" target="_blank" class="modal-btn-download" download>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/globalbit/download-icon.png"/>
                    <span>הורדה של קובץ PDF</span>
                </a>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/globalbit/close-icon.png"/>
                </button>
            </div>

            <div class="modal-body">
                <img src="" id="view-pdf-image"/>

                <a href="" target="_blank" class="modal-btn-download" download>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/globalbit/download-icon.png"/>
                    <span>הורדה של קובץ PDF</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    jQuery('.view-pdf').on('click', function (event) {
        event.preventDefault();

        jQuery('#viewModal').modal();

        const element = jQuery(this);

        jQuery('.modal-btn-download').attr('href', element.attr('href'));
        jQuery('#view-pdf-image').attr('src', element.data('image'));
    })
</script>
