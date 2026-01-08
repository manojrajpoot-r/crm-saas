@extends('tenant.layouts.tenant_master')

@section('content')

     <div class="main-panel">
				<div class="content">
					<div class="container-fluid">
					<h2>
                            {{ $mode === 'saas' ? 'SaaS Admin Dashboard' : 'Tenant Dashboard' }}
                        </h2>
						<div class="row">
							<div class="col-md-3">
								<div class="card card-stats card-warning">
									<div class="card-body ">
										<div class="row">
											<div class="col-5">
												<div class="icon-big text-center">
													<i class="la la-users"></i>
												</div>
											</div>

                                            @if($mode === 'saas')
                                              <div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Users</p>
													<h4 class="card-title">1,294</h4>
												</div>
											</div>
                                            @else
                                                <div class="col-7 d-flex align-items-center">
												<div class="numbers">
													<p class="card-category">Tenant Users</p>
													<h4 class="card-title">1,294</h4>
												</div>
											</div>
                                            @endif

										</div>
									</div>
								</div>
							</div>


						</div>


					</div>
				</div>

			</div>

@endsection
