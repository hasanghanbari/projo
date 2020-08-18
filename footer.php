	        </div>
	        <!-- /.row -->
	    </div>
	    <!-- /.container-fluid -->
	</div>
	</div>
	<!-- Modal show task -->
	<div class="modal fade modal-add-project" id="show_add_project" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	       	<div class="modal-body">
	       		<div class="row">
	       			<div class="col-8">
	       				<div class="card card-body example-new-card">
	       					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; left: 10px; top: 10px; color: #fff">
					          <span aria-hidden="true">&times;</span>
					        </button>
	       					<input type="text" class="form-control" id="title-project" name="title-project" placeholder="عنوان پروژه">
	       					<div class="upload-btn-wrapper">
	       					  <label for="logo" class="btn">لوگو</label>
	       					  <input type="file" name="logo" id="logo">
	       					</div>
	       				</div>
	       			</div>
	       			<div class="col-4">
	       				<div class="form-group form-check bg-color-project">
	       					<span>
	       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project1" value="fd7e14" checked>
	       						<label class="form-check-label" for="bg_color_project1" onclick="activeColor(1)">
	       							<span class="box-color" style="background-color: #fd7e14">
	       								<i class="fal fa-check" id="check_bg_color_project1" style="display: block"></i>
	       							</span>
	       						</label>
	       					</span>
	       					<span>
	       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project2" value="007bff">
	       						<label class="form-check-label" for="bg_color_project2" onclick="activeColor(2)">
	       							<span class="box-color" style="background-color: #007bff">
	       								<i class="fal fa-check" id="check_bg_color_project2"></i>
	       							</span>
	       						</label>
	       					</span>
	       					<span>
	       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project3" value="6f42c1">
	       						<label class="form-check-label" for="bg_color_project3" onclick="activeColor(3)">
	       							<span class="box-color" style="background-color: #6f42c1">
	       								<i class="fal fa-check" id="check_bg_color_project3"></i>
	       							</span>
	       						</label>
	       					</span>
	       					<span>
	       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project4" value="dc3545">
	       						<label class="form-check-label" for="bg_color_project4" onclick="activeColor(4)">
	       							<span class="box-color" style="background-color: #dc3545">
	       								<i class="fal fa-check" id="check_bg_color_project4"></i>
	       							</span>
	       						</label>
	       					</span>
	       					<span>
	       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project5" value="ffc107">
	       						<label class="form-check-label" for="bg_color_project5" onclick="activeColor(5)">
	       							<span class="box-color" style="background-color: #ffc107">
	       								<i class="fal fa-check" id="check_bg_color_project5"></i>
	       							</span>
	       						</label>
	       					</span>
	       					<span>
	       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project6" value="28a745">
	       						<label class="form-check-label" for="bg_color_project6" onclick="activeColor(6)">
	       							<span class="box-color" style="background-color: #28a745">
	       								<i class="fal fa-check" id="check_bg_color_project6"></i>
	       							</span>
	       						</label>
	       					</span>
	       					<span>
	       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project7" value="17a2b8">
	       						<label class="form-check-label" for="bg_color_project7" onclick="activeColor(7)">
	       							<span class="box-color" style="background-color: #17a2b8">
	       								<i class="fal fa-check" id="check_bg_color_project7"></i>
	       							</span>
	       						</label>
	       					</span>
	       					<span>
	       						<input type="radio" class="form-check-input" name="bg_color_project" id="bg_color_project8" value="20c997">
	       						<label class="form-check-label" for="bg_color_project8" onclick="activeColor(8)">
	       							<span class="box-color" style="background-color: #20c997">
	       								<i class="fal fa-check" id="check_bg_color_project8"></i>
	       							</span>
	       						</label>
	       					</span>
		   				</div>
	       			</div>
	       		</div>
	       		<button class="btn btn-success">ایجاد پروژه</button>
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