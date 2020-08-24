	        </div>
	        <!-- /.row -->
	    </div>
	    <!-- /.container-fluid -->
	</div>
	</div>
	<!-- Modal add project -->
	<div class="modal fade modal-add-project" id="show_add_project" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	       	<div class="modal-body">
	       		<form id="project" method="post" enctype="multipart/form-data">
		       		<div class="row">
		       			<div class="col-8">
		       				<div class="card card-body example-new-card">
		       					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; left: 10px; top: 10px; color: #fff">
						          <span aria-hidden="true">&times;</span>
						        </button>
		       					<input type="text" class="form-control" id="title-project" name="title-project" placeholder="عنوان پروژه">
		       					<input type="hidden" name="op" value="add_project">
		       					<div class="upload-btn-wrapper">
		       					  <label for="logo" class="btn">لوگو</label>
		       					  <input type="file" name="logo" id="logo">
		       					</div>
		       				</div>
		       			</div>
		       			<div class="col-4">
		       				<div class="form-group form-check bg-color-project">
		       					<span>
		       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_1" value="fd7e14" checked>
		       						<label class="form-check-label" for="bg_color_project_mini_1" onclick="activeColorMini(1)">
		       							<span class="box-color" style="background-color: #fd7e14">
		       								<i class="fal fa-check" id="check_bg_color_project_add_1" style="display: block"></i>
		       							</span>
		       						</label>
		       					</span>
		       					<span>
		       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_2" value="007bff">
		       						<label class="form-check-label" for="bg_color_project_mini_2" onclick="activeColorMini(2)">
		       							<span class="box-color" style="background-color: #007bff">
		       								<i class="fal fa-check" id="check_bg_color_project_add_2"></i>
		       							</span>
		       						</label>
		       					</span>
		       					<span>
		       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_3" value="6f42c1">
		       						<label class="form-check-label" for="bg_color_project_mini_3" onclick="activeColorMini(3)">
		       							<span class="box-color" style="background-color: #6f42c1">
		       								<i class="fal fa-check" id="check_bg_color_project_add_3"></i>
		       							</span>
		       						</label>
		       					</span>
		       					<span>
		       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_4" value="dc3545">
		       						<label class="form-check-label" for="bg_color_project_mini_4" onclick="activeColorMini(4)">
		       							<span class="box-color" style="background-color: #dc3545">
		       								<i class="fal fa-check" id="check_bg_color_project_add_4"></i>
		       							</span>
		       						</label>
		       					</span>
		       					<span>
		       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_5" value="ffc107">
		       						<label class="form-check-label" for="bg_color_project_mini_5" onclick="activeColorMini(5)">
		       							<span class="box-color" style="background-color: #ffc107">
		       								<i class="fal fa-check" id="check_bg_color_project_add_5"></i>
		       							</span>
		       						</label>
		       					</span>
		       					<span>
		       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_6" value="28a745">
		       						<label class="form-check-label" for="bg_color_project_mini_6" onclick="activeColorMini(6)">
		       							<span class="box-color" style="background-color: #28a745">
		       								<i class="fal fa-check" id="check_bg_color_project_add_6"></i>
		       							</span>
		       						</label>
		       					</span>
		       					<span>
		       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_7" value="17a2b8">
		       						<label class="form-check-label" for="bg_color_project_mini_7" onclick="activeColorMini(7)">
		       							<span class="box-color" style="background-color: #17a2b8">
		       								<i class="fal fa-check" id="check_bg_color_project_add_7"></i>
		       							</span>
		       						</label>
		       					</span>
		       					<span>
		       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project_mini_8" value="20c997">
		       						<label class="form-check-label" for="bg_color_project_mini_8" onclick="activeColorMini(8)">
		       							<span class="box-color" style="background-color: #20c997">
		       								<i class="fal fa-check" id="check_bg_color_project_add_8"></i>
		       							</span>
		       						</label>
		       					</span>
			   				</div>
		       			</div>
		       		</div>
		       		<div id="show-resault-add_project"></div>
		       		<button class="btn btn-success">ایجاد پروژه</button>
		       	</form>
	        </div>
	    </div>
	  </div>
	</div>
	<!-- <script src="vendor/tinymce/tinymce.min.js"></script> -->
	<script type="text/javascript" src="vendor/RichText/src/jquery.richtext.js"></script>

	<script type="text/javascript" src="vendor/Persian-Jalali/src/kamadatepicker.min.js"></script>
	<script type="text/javascript" src="vendor/mousewheel/jquery.mousewheel.js"></script>

	<script type="text/javascript" src="themes/2020/js/scripts.js"></script>

  </body>
</html>