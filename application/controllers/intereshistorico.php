<?php

class Intereshistorico extends MY_Controller {
		
		function __construct() {
		parent::__construct();
		$this->load->library('form_validation');		
		$this->load->helper(array('form','url','codegen_helper'));
		$this->load->model('codegen_model','',TRUE);

	}	
	
	function index(){
		$this->manage();
	}

	function manage(){
				if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('intereshistorico/manage'))
							 {
								//template data
								$this->template->set('title', 'Interés Histórico');
								$this->data['style_sheets']= array(
														'css/jquery.dataTables_themeroller.css' => 'screen'
												);
								$this->data['javascripts']= array(
														'js/jquery.dataTables.min.js',
														'js/jquery.dataTables.defaults.js'
												);
								$this->data['message']=$this->session->flashdata('message');
								$this->template->load($this->template_file, 'intereshistorico/intereshistorico_list',$this->data); 
							 }else {
								$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
											redirect(base_url().'index.php/inicio');
							 } 

						}else
						{
							redirect(base_url().'index.php/auth/login');
						}
		}
	
		function add(){        
				if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('intereshistorico/add'))
							 {
										$this->load->library('form_validation');    
										$this->data['custom_error'] = '';
										$showForm=0;
										$this->form_validation->set_rules('tasahistorico', 'Tasa histórico', 'required|trim|xss_clean|max_length[128]');
										$this->form_validation->set_rules('tipotasa', 'Tipo Tasa', 'required|numeric');

										if ($this->form_validation->run() == false)
										{
												 $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'.validation_errors().'</div>' : false);

										} else
										{    
												
												$data = array(
																'IDTASA' => $this->codegen_model->getSequence('dual','IDTASASEQ.NEXTVAL'),
																'IDCONCEPTO' => set_value('concepto'),
																'VALORTASA' => set_value('valortasa'),
																'IDESTADO' => set_value('estado_id')
												);
												 
									if ($this->codegen_model->add('TASA_ACUERDO_PAGO',$data) == TRUE)
									{
										$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La tasa de pago se ha creado con éxito.</div>');
													redirect(base_url().'index.php/intereshistorico/');
									}
									else
									{
										$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';

									}
								}
										//add style an js files for inputs selects
										$this->data['style_sheets']= array(
														'css/chosen.css' => 'screen'
												);
										$this->data['javascripts']= array(
														'js/chosen.jquery.min.js'
												);
										$this->data['estados']  = $this->codegen_model->getSelect('ESTADOS','IDESTADO,NOMBREESTADO');
															
										$this->template->load($this->template_file, 'intereshistorico/intereshistorico_add', $this->data);
								}else {
										$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
													redirect(base_url().'index.php/intereshistorico');
									 }
							 }
						else
						{
							redirect(base_url().'index.php/auth/login');
						}
		}

	function addrango(){        
				if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('intereshistorico/addrango'))
							 {
										$this->load->library('form_validation');    
										$this->data['custom_error'] = '';
										$showForm=0;
										$this->form_validation->set_rules('tasahistorico', 'Tasa histórico', 'required|trim|xss_clean|max_length[128]');
										$this->form_validation->set_rules('tipotasa', 'Tipo Tasa', 'required|numeric');

										if ($this->form_validation->run() == false)
										{
												 $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'.validation_errors().'</div>' : false);

										} else
										{    
												
												$data = array(
																'IDTASA' => $this->codegen_model->getSequence('dual','IDTASASEQ.NEXTVAL'),
																'IDCONCEPTO' => set_value('concepto'),
																'VALORTASA' => set_value('valortasa'),
																'IDESTADO' => set_value('estado_id')
												);
												 
									if ($this->codegen_model->add('TASA_ACUERDO_PAGO',$data) == TRUE)
									{
										$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La tasa de pago se ha creado con éxito.</div>');
													redirect(base_url().'index.php/intereshistorico/');
									}
									else
									{
										$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';

									}
								}
										//add style an js files for inputs selects
										$this->data['style_sheets']= array(
														'css/datepicker.css' => 'screen',
														'css/bootstrap.css' => 'screen',
														'css/datepicker.css' => 'screen',

												);
										$this->data['javascripts']= array(
														'js/chosen.jquery.min.js',
														'js/bootstrap-datepicker.js'
												);

										$this->data['result'] = $this->codegen_model->get('TASA_ACUERDO_PAGO','IDTASA,IDCONCEPTO,VALORTASA,IDESTADO','IDTASA = '.$this->uri->segment(3),1,1,true);
										$this->data['estados']  = $this->codegen_model->getSelect('ESTADOS','IDESTADO,NOMBREESTADO');
																			
										$this->template->load($this->template_file, 'intereshistorico/intereshistorico_add_rango', $this->data);
								}else {
										$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
													redirect(base_url().'index.php/intereshistorico');
									 }
							 }
						else
						{
							redirect(base_url().'index.php/auth/login');
						}
		}




	function edit(){    
				if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('intereshistorico/edit'))
							 {    
								$ID =  $this->uri->segment(3);
										if ($ID==""){
											$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No hay un ID para editar.</div>');
													redirect(base_url().'index.php/intereshistorico');
										}else{
															$this->load->library('form_validation');  
													$this->data['custom_error'] = '';
													$this->form_validation->set_rules('valortasa', 'Valor Tasa', 'required|numeric');  
															$this->form_validation->set_rules('estado_id', 'Estado',  'required|numeric|greater_than[0]');  
															if ($this->form_validation->run() == false)
															{
																	 $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'.validation_errors().'</div>' : false);
																	
															} else
															{                            
																	$data = array(
																					'VALORTASA' => $this->input->post('valortasa'),
																					'IDESTADO' => $this->input->post('estado_id')
																	);
																 
														if ($this->codegen_model->edit('TASA_ACUERDO_PAGO',$data,'IDTASA',$this->input->post('id')) == TRUE)
														{
															$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La tasa de pago se ha editado correctamente.</div>');
																			redirect(base_url().'index.php/intereshistorico/');
														}
														else
														{
															$this->data['custom_error'] = '<div class="error"><p>Ha ocurrido un error</p></div>';

														}
													}
															$this->data['result'] = $this->codegen_model->get('TASA_ACUERDO_PAGO','IDTASA,IDCONCEPTO,VALORTASA,IDESTADO','IDTASA = '.$this->uri->segment(3),1,1,true);
															$this->data['estados']  = $this->codegen_model->getSelect('ESTADOS','IDESTADO,NOMBREESTADO');
																	
																	//add style an js files for inputs selects
																	$this->data['style_sheets']= array(
																					'css/chosen.css' => 'screen'
																			);
																	$this->data['javascripts']= array(
																					'js/chosen.jquery.min.js'
																			);

																	$this->template->load($this->template_file, 'intereshistorico/intereshistorico_edit', $this->data); 
											}
								}else {
										$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
													redirect(base_url().'index.php/intereshistorico');
									 }
								
						}else
								{
								redirect(base_url().'index.php/auth/login');
								}
				
		}

		function editrango(){    
				if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('intereshistorico/editrango'))
							 {    
								$ID =  $this->uri->segment(3);
										if ($ID==""){
											$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No hay un ID para editar.</div>');
													redirect(base_url().'index.php/intereshistorico');
										}else{
															$this->load->library('form_validation');  
													$this->data['custom_error'] = '';
													$this->form_validation->set_rules('valortasa', 'Valor Tasa', 'required|numeric');  
															$this->form_validation->set_rules('estado_id', 'Estado',  'required|numeric|greater_than[0]');  
															if ($this->form_validation->run() == false)
															{
																	 $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'.validation_errors().'</div>' : false);
																	
															} else
															{                            
																	$data = array(
																					'VALORTASA' => $this->input->post('valortasa'),
																					'IDESTADO' => $this->input->post('estado_id')
																	);
																 
														if ($this->codegen_model->edit('TASA_ACUERDO_PAGO',$data,'IDTASA',$this->input->post('id')) == TRUE)
														{
															$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La tasa de pago se ha editado correctamente.</div>');
																			redirect(base_url().'index.php/intereshistorico/');
														}
														else
														{
															$this->data['custom_error'] = '<div class="error"><p>Ha ocurrido un error</p></div>';

														}
													}
															$this->data['result'] = $this->codegen_model->get('TASA_ACUERDO_PAGO','IDTASA,IDCONCEPTO,VALORTASA,IDESTADO','IDTASA = '.$this->uri->segment(3),1,1,true);
															$this->data['estados']  = $this->codegen_model->getSelect('ESTADOS','IDESTADO,NOMBREESTADO');
																	
																	//add style an js files for inputs selects
																	$this->data['style_sheets']= array(
																					'css/datepicker.css' => 'screen',
																					'css/bootstrap.css' => 'screen',
																					'css/datepicker.css' => 'screen',

																			);
																	$this->data['javascripts']= array(
																					'js/chosen.jquery.min.js',
																					'js/bootstrap-datepicker.js'
																			);

																	$this->template->load($this->template_file, 'intereshistorico/intereshistorico_edit_rango', $this->data); 
											}
								}else {
										$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
													redirect(base_url().'index.php/intereshistorico');
									 }
								
						}else
								{
								redirect(base_url().'index.php/auth/login');
								}
				
		}

		function rangos(){    
				if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('intereshistorico/rangos'))
							 {    
								$ID =  $this->uri->segment(3);
										if ($ID==""){
											$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No hay un ID para editar.</div>');
													redirect(base_url().'index.php/intereshistorico');
										}else{
															
																	
														$this->data['style_sheets']= array(
																				'css/jquery.dataTables_themeroller.css' => 'screen'
																					);
														$this->data['javascripts']= array(
																				'js/jquery.dataTables.min.js',
																				'js/jquery.dataTables.defaults.js'
																		);
														$this->data['result'] = $this->codegen_model->get('TASA_ACUERDO_PAGO','IDTASA,IDCONCEPTO,VALORTASA,IDESTADO','IDTASA = '.$this->uri->segment(3),1,1,true);
														$this->data['estados']  = $this->codegen_model->getSelect('ESTADOS','IDESTADO,NOMBREESTADO');
																

														$this->template->load($this->template_file, 'intereshistorico/intereshistorico_list_rangos', $this->data); 
											}
							}else {
									$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
									redirect(base_url().'index.php/intereshistorico');
								}
								
					}else
						{
						redirect(base_url().'index.php/auth/login');
						}
				
		}
	
		function delete(){
				 if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('intereshistorico/delete'))
							 {
										$ID =  $this->uri->segment(3);
										if ($ID==""){
											$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>Debe Eliminar mediante edición.</div>');
													redirect(base_url().'index.php/intereshistorico');
										}else{
											 $data = array(
                                    				'IDESTADO' => '2'

				                            	);
				           				if($this->codegen_model->edit('TASA_ACUERDO_PAGO',$data,'IDTASA',$ID) == TRUE){
												//$this->codegen_model->delete('TASA_ACUERDO_PAGO','IDTASA',$ID);             
												$this->template->set('title', 'intereshistorico');
												$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La tasa de pado se eliminó correctamente.'.$ID.'</div>');
												redirect(base_url().'index.php/intereshistorico/');
										}
									}
								}else {
										$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
													redirect(base_url().'index.php/intereshistorico');
									 }
					}else
						{
							redirect(base_url().'index.php/auth/login');
						}
		}
 
		 function datatable (){
				if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('intereshistorico/manage'))
							 {
							 
							 if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('intereshistorico/edit'))
							 {
								$this->load->library('datatables');
								$this->datatables->select('TASA_ACUERDO_PAGO.IDTASA,C.NOMBRECONCEPTO, TASA_ACUERDO_PAGO.VALORTASA,');
								$this->datatables->from('TASA_ACUERDO_PAGO'); 
								$this->datatables->join('CONCEPTO C','C.IDCONCEPTO = TASA_ACUERDO_PAGO.IDCONCEPTO', ' inner ');
								$this->datatables->add_column('edit', '<div class="btn-toolbar">
																													 <div class="btn-group">
																															<a href="'.base_url().'index.php/intereshistorico/edit/$1" class="btn btn-small" title="Editar"><i class="icon-edit"></i></a>
																													 </div>
																											 </div>', 'TASA_ACUERDO_PAGO.IDTASA');
								$this->datatables->add_column('rangos', '<div class="btn-toolbar">
																													 <div class="btn-group">
																															<a href="'.base_url().'index.php/intereshistorico/rangos/$1" class="btn btn-small" title="Rangos"><i class="icon-edit"></i></a>
																													 </div>
																											 </div>', 'TASA_ACUERDO_PAGO.IDTASA');
							}else{
								$this->load->library('datatables');
								$this->datatables->select('TASA_ACUERDO_PAGO.IDTASA,C.NOMBRECONCEPTO, TASA_ACUERDO_PAGO.VALORTASA,E.NOMBREESTADO');
								$this->datatables->from('TASA_ACUERDO_PAGO'); 
								$this->datatables->join('ESTADOS E','E.IDESTADO = TASA_ACUERDO_PAGO.IDESTADO', ' inner ');
								$this->datatables->join('CONCEPTO C','C.IDCONCEPTO = TASA_ACUERDO_PAGO.IDCONCEPTO', ' inner ');
								$this->datatables->add_column('edit', '<div class="btn-toolbar">
																													 <div class="btn-group">
																															<a href="#" class="btn btn-small disabled" title="Editar"><i class="icon-edit"></i></a>
																													 </div>
																											 </div>', 'TASA_ACUERDO_PAGO.IDTASA');
							}
								echo $this->datatables->generate();
								}else {
										$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
													redirect(base_url().'index.php/intereshistorico');
									 }
						}else
						{
							redirect(base_url().'index.php/auth/login');
						}           
		}

		function datatablerangos (){
				if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('intereshistorico/manage'))
							 {
							 
							 if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('intereshistorico/edit'))
							 {
							 	$ID =  $this->uri->segment(3);

								$this->load->library('datatables');
								$this->datatables->select('TASA_ACUERDO_PAGO.IDTASA,C.NOMBRECONCEPTO, TASA_ACUERDO_PAGO.VALORTASA,');
								$this->datatables->from('TASA_ACUERDO_PAGO'); 
								$this->datatables->join('CONCEPTO C','C.IDCONCEPTO = TASA_ACUERDO_PAGO.IDCONCEPTO', ' inner ');
								$this->datatables->where('TASA_ACUERDO_PAGO.IDTASA', $ID);
								$this->datatables->add_column('edit', '<div class="btn-toolbar">
																													 <div class="btn-group">
																															<a href="'.base_url().'index.php/intereshistorico/editrango/$1" class="btn btn-small" title="Editar"><i class="icon-edit"></i></a>
																													 </div>
																											 </div>', 'TASA_ACUERDO_PAGO.IDTASA');
								
								}else{
								$this->load->library('datatables');
								$this->datatables->select('TASA_ACUERDO_PAGO.IDTASA,C.NOMBRECONCEPTO, TASA_ACUERDO_PAGO.VALORTASA,E.NOMBREESTADO');
								$this->datatables->from('TASA_ACUERDO_PAGO'); 
								$this->datatables->join('ESTADOS E','E.IDESTADO = TASA_ACUERDO_PAGO.IDESTADO', ' inner ');
								$this->datatables->join('CONCEPTO C','C.IDCONCEPTO = TASA_ACUERDO_PAGO.IDCONCEPTO', ' inner ');
								$this->datatables->add_column('edit', '<div class="btn-toolbar">
																													 <div class="btn-group">
																															<a href="#" class="btn btn-small disabled" title="Editar"><i class="icon-edit"></i></a>
																													 </div>
																											 </div>', 'TASA_ACUERDO_PAGO.IDTASA');
							}
								echo $this->datatables->generate();
								}else {
										$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
													redirect(base_url().'index.php/intereshistorico');
									 }
						}else
						{
							redirect(base_url().'index.php/auth/login');
						}           
		}

}


/* End of file intereshistorico.php */
/* Location: ./system/application/controllers/intereshistorico.php */