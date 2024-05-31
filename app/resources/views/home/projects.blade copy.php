@extends('layouts.home')
@section('content')
<div class="breadcrumb-main">
	<div class="container">
		<div class="breadcrumb-container">
			<h2 class="page-title">Projects</h2>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fas fa-home"></i></a></li>
				<li class="breadcrumb-item"><a href="{{url('/')}}/projects">Projects</a></li>
			</ul>
		</div>
	</div>
</div>
<main>
	<div id="project-category" class="container">
		<div class="row">
			<div id="content" class="col">
				<div class="category-info">
					<div id="display-control" class="row">
						<div class="col-sm-5 col-xs-12 category-list-grid">
							<div class="btn-group">
								<button type="button" id="button-grid" class="btn btn-default" data-bs-toggle="tooltip" title="Grid"><i class="icon-grid"></i></button>
								<button type="button" id="button-list" class="btn btn-default" data-bs-toggle="tooltip" title="List"><i class="icon-list"></i></button>
							</div>
						</div>
						<div class="col-md-7 col-xs-12 category-sorting">
							<div class="sort-cat">
								<div class="text-category-sort">
									<label for="input-sort" class="input-group-text input-group-addon">Sort By</label>
								</div>
								<div class="select-cat-sort">
									<select id="input-sort" class="form-select form-control">
										<option value="default" selected="">Default</option>
										<option value="ProjectName-Asc">Name (A - Z)</option>
										<option value="ProjectName-Desc">Name (Z - A)</option>
										@if($Settings['show-price-on-home']==true)
                                            <option value="price-low-high">Price (Low &gt; High)</option>
                                            <option value="rice-high-low">Price (High &gt; Low)</option>
										@endif
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="project-list" class="project-grid row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4">

				</div>
				<div class="pagination-main" >
					<div class="row">
						<div class="col-md-6 pagination_result" id="pagination_result">Showing 1 to 8 of 16 (2 Pages)</div>
						<div class="col-md-6 text-md-end">
							<ul class="pagination">
								<li class="page-item next" id="previous-page"><a href="#" class="page-link"> < </a></li>
								<li class="page-item active"><a href="#" class="page-link">1</a></li>
								<li class="page-item page"><a href="#" class="page-link">2</a></li>
								<li class="page-item next" id="next-page"><a href="#" class="page-link"> > </a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<script>
    $(document).ready(function(){
        let TotalProjects=parseInt("{{$ProjectsCount}}");
        let currentPage=1;
        let limitPerPage=8;
		var totalPages = Math.ceil(TotalProjects / limitPerPage);
		var paginationSize = 7;
        const showPageInfo=()=>{
			let from =(currentPage-1)*limitPerPage;
			let to =from+limitPerPage;
			to=TotalProjects<to?TotalProjects:to;
			let text="Showing "+(from+1)+" to "+to+" of "+TotalProjects+" ("+totalPages+" Pages)";
			$('#pagination_result').html(text);
        }
		const getProjects=()=>{
			let sortby=$('#input-sort').val();
			$.ajax({
                type:"post",
                url:"{{url('/')}}/get/projects",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
				data:{currentPage,limitPerPage,sortby},
                async:true,
                success:function(response){
					$('#project-list').html(response);
                }
            });
		}
        const getPageList=(totalPages, page, maxLength) =>{
            if (maxLength < 5) throw "maxLength must be at least 5";

            function range(start, end) {
                return Array.from(Array(end - start + 1), (_, i) => i + start);
            }

            var sideWidth = maxLength < 9 ? 1 : 2;
            var leftWidth = (maxLength - sideWidth*2 - 3) >> 1;
            var rightWidth = (maxLength - sideWidth*2 - 2) >> 1;
            if (totalPages <= maxLength) {
                // no breaks in list
                return range(1, totalPages);
            }
            if (page <= maxLength - sideWidth - 1 - rightWidth) {
                // no break on left of page
                return range(1, maxLength - sideWidth - 1).concat(0, range(totalPages - sideWidth + 1, totalPages));
            }
            if (page >= totalPages - sideWidth - 1 - rightWidth) {
                // no break on right of page
                return range(1, sideWidth).concat(0, range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages));
            }
            // Breaks on both sides
            return range(1, sideWidth).concat(0, range(page - leftWidth, page + rightWidth),0, range(totalPages - sideWidth + 1, totalPages));
        }
        const showPage=(whichPage) =>{
            if (whichPage < 1 || whichPage > totalPages) return false;
            currentPage = whichPage;
            // Replace the navigation items (not prev/next):
            $(".pagination li").slice(1, -1).remove();
            getPageList(totalPages, currentPage, paginationSize).forEach( item => {
                $("<li>").addClass("page-item")
                        .addClass(item ? "current-page" : "disabled")
                        .toggleClass("active", item === currentPage).append(
                    $("<a>").addClass("page-link").attr({
                        href: "javascript:void(0)"}).text(item || "...")
                ).insertBefore("#next-page");
            });
            // Disable prev/next when at first/last page:
            $("#previous-page").toggleClass("disabled", currentPage === 1);
            $("#next-page").toggleClass("disabled", currentPage === totalPages);
			getProjects();
			showPageInfo();
            return true;
        }

        const appInit=()=>{
    		showPage(currentPage);
        }
		$(document).on('change','#input-sort',function(){
			return showPage(currentPage);
		});
		$(document).on("click", ".pagination li.current-page:not(.active)", function () {
			return showPage(+$(this).text());
		});
		$("#next-page").on("click", function () {
			return showPage(currentPage+1);
		});

		$("#previous-page").on("click", function () {
			return showPage(currentPage-1);
		});
        appInit();
    });
</script>
@endsection
