require(['jquery'], function ($, $t) {
    $(document).ready(function () {
        $(".level0.last").click(function () {
            $(".level0.category-item").removeClass("active");
            $(".level0.level-top").removeClass("active");
        })
    })
})
