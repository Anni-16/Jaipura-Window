 
				<div class="category-info">
					<div class="row">
						<!-- Grid/List View Toggle -->
						<div class="col-sm-2 col-xs-5 category-list-grid text-start">
							<div class="btn-group btn-group-sm">
								<button type="button" id="grid-view" class="btn btn-default active" data-original-title="Grid">
									<i class="icon-grid"></i>
								</button>
								<button type="button" id="list-view" class="btn btn-default" data-original-title="List">
									<i class="icon-list"></i>
								</button>
								
							</div>
						</div>

						<!-- Sorting and Limit Section -->
						<div class="col-sm-7 col-xs-12 category-sorting">
							<!-- Sorting Section -->
							<div class="sort-cat">
								<div class="text-category-sort">
									<label class="input-group-addon" for="input-sort">Sort By:</label>
								</div>
								<div class="select-cat-sort">
									<select id="input-sort" class="form-control" onchange="updateFilter()">
										<option value="default" selected="selected">Default</option>
										<option value="name-asc">Name (A - Z)</option>
										<option value="name-desc">Name (Z - A)</option>
										<option value="price-asc">Price (Low > High)</option>
										<option value="price-desc">Price (High > Low)</option>
									</select>
								</div>
							</div>

							<!-- Limit Section -->
							<div class="limit-cat">
								<div class="text-category-limit">
									<label class="input-group-addon" for="input-limit">Show:</label>
								</div>
								<div class="select-cat-limit">
									<select id="input-limit" class="form-control" onchange="updateFilter()">
										<option value="50" selected="selected">50</option>
										<option value="75">75</option>
										<option value="100">100</option>
										<option value="125">125</option>
										<option value="150">150</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>