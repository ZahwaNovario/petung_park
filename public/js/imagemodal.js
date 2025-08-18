$(document).ready(function () {
    // Ketika gambar kecil diklik
    $(".zoomimg").click(function () {
        var id = $(this).attr("id");
        var tjudul = $("#text_" + id).text();
        console.log(tjudul);
        var src = $(this).attr("src");
        $("#modalJudul").text(tjudul);
        $("#modalImage").attr("src", src);
        $('#imageModal').modal('show');
    });
});