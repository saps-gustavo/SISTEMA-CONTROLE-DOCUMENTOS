<script> $(document).ready(function () {
	mudaCorTabs();

	function mudaCorTabs()
    {
        //muda cor default das tabs
        // TAB Color
        $(".tabs" ).addClass("blue-grey lighten-5"); 

        // TAB Indicator/Underline Color
        $(".tabs>.indicator").addClass("teal");

        // TAB Text Color
        $(".tabs>li>a").addClass("teal-text"); 
    } 
});

</script>
	