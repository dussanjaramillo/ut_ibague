<?php

class Cnm_calamidad extends MY_Controller {
		
		function __construct() {
				parent::__construct();
		$this->load->library('form_validation');		
		$this->load->helper(array('form','url','codegen_helper','template_helper','traza_fecha_helper'));
		$this->load->model('cnm_calamidad_model','',TRUE);
		$this->load->file(APPPATH . "controllers/cnm_liquidacioncuotas.php", true);
		
		$this->data['javascripts'] = array(
            
            'js/tinymce/tinymce.jquery.min.js',
			'js/jquery.dataTables.min.js',
        	'js/jquery.validationEngine-es.js',
            'js/jquery.validationEngine.js',
            'js/validateForm.js',

        	        );
                $this->data['style_sheets']= array(
                        'css/jquery.dataTables_themeroller.css' => 'screen',
				        'css/validationEngine.jquery.css' => 'screen'
                        
                );
                
	}	


	
	
	
	
	var $nit;
	var $razon_social;
		

	
	function index(){
		$this->manage();
	}

	function manage(){
				if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('fiscalizacion/manage'))
							 {
	        
								         
										 
								$usuario= $this->ion_auth->user()->row()->IDUSUARIO;		 
								        

                       


                // var_dump( $this->data['empresas']);
										// die();
        
								
								//template data
								$this->template->set('title', 'Fiscalizacion');
								$this->data['style_sheets']= array(
														'css/jquery.dataTables_themeroller.css' => 'screen',
														'css/validationEngine.jquery.css' => 'screen'
												);
								
								
								$this->data['message']=$this->session->flashdata('message');
								$this->template->load($this->template_file, 'fiscalizacion/fiscalizacion_list',$this->data); 
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
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('carteranomisional/add'))
							 {
					$this->template->set('title', 'Registro Cartera Calamidad Doméstica');

												
												$flag=$this->input->post('vista_flag');
										if(!empty($flag)){
											
										
											
										$this->form_validation->set_rules('cedula', 'Cedula', 'required');

												if ($this->form_validation->run() == false)
										{

												 $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'.validation_errors().'</div>' : false);

										} else
										{
											
											$empleadoEx=$this->cnm_calamidad_model->countEmpleado($this->input->post('cedula'));
											if($empleadoEx['EXIST']==1)
											{
												
date_default_timezone_set("America/Bogota");
											$tasa_corriente=$this->input->post('t_i_c');
												if(!empty($tasa_corriente))
					{	$mod_tasa_corr='S';
						$calc_corriente= $this->input->post('combo_tipo_tasa_corriente');
						switch($calc_corriente)
						{case '1':
						$tipo_t_f_corriente= $this->input->post('aplica_tasa_c');
						$tipo_t_v_corriente= "";
						$valor_t_corriente= $this->input->post('porcent_tasa_c');
							break;
							
						case '2':
						$tipo_t_f_corriente= "";
						$tipo_t_v_corriente= $this->input->post('aplica_tasa_c');
						$valor_t_corriente= "";
							break;
							
						default:
						$tipo_t_f_corriente= "";
						$tipo_t_v_corriente= "";
						$valor_t_corriente= "";

						break;		
						}
						
						
					}
												else
													{
						$mod_tasa_corr='N';								
						$calc_corriente= "";
						$tipo_t_f_corriente= "";
						$tipo_t_v_corriente= "";
						$valor_t_corriente= "";
													}
													
													
								$tasa_mora=$this->input->post('t_i_m');
												if(!empty($tasa_mora))
					{
						$mod_tasa_mora='S';		
						$calc_mora= $this->input->post('combo_tipo_tasa_mora');
						switch($calc_mora)
						{case '1':
						$tipo_t_f_mora= $this->input->post('aplica_tasa_m');
						$tipo_t_v_mora= "";
						$valor_t_mora= $this->input->post('porcent_tasa_m');
							break;
							
						case '2':
						$tipo_t_f_mora= "";
						$tipo_t_v_mora= $this->input->post('aplica_tasa_m');
						$valor_t_mora= "";
							break;
							
						default:
						$tipo_t_f_mora= "";
						$tipo_t_v_mora= "";
						$valor_t_mora= "";

						break;		
						}
						
						
					}
												else
													{
						$mod_tasa_mora='N';									
						$calc_mora= "";
						$tipo_t_f_mora= "";
						$tipo_t_v_mora= "";
						$valor_t_mora= "";
													}					
												
												
																								$datecnm = array(
												'FECHA_CREACION' =>  date("d/m/Y H:i:s"),

												);

												$datacnm = array(
																'COD_TIPOCARTERA' => '1',
																'COD_PROCESO_REALIZADO' => '1',
																'COD_REGIONAL' => $this->ion_auth->user()->row()->COD_REGIONAL,
																'COD_EMPLEADO' => $this->input->post('cedula'),
																'COD_ESTADO' => $this->input->post('tipo_estado_id'),			
																'COD_TIPO_ACUERDO' => $this->input->post('tipo_acuerdo_id'),	
																'VALOR_DEUDA' => str_replace(".", "", $this->input->post('valor_deuda')),
																'SALDO_DEUDA' => str_replace(".", "", $this->input->post('valor_deuda')),
																'COD_FORMAPAGO' => $this->input->post('forma_pago_id'),	
																'PLAZO_CUOTAS' => $this->input->post('plazo'),
																'COD_PLAZO' => $this->input->post('plazo_id'),	
																'CALCULO_CORRIENTE' => $calc_corriente,
																'TIPO_T_F_CORRIENTE' => $tipo_t_f_corriente,
																'TIPO_T_V_CORRIENTE' => $tipo_t_v_corriente,
																'VALOR_T_CORRIENTE' => $valor_t_corriente,		
																'CALCULO_MORA' => $calc_mora,
																'TIPO_T_F_MORA' => $tipo_t_f_mora,
																'TIPO_T_V_MORA' => $tipo_t_v_mora,
																'VALOR_T_MORA' => $valor_t_mora,														
												);
												
												
									if ($this->cnm_calamidad_model->add('CNM_CARTERANOMISIONAL',$datacnm,$datecnm) == TRUE)
									{
										$id_cartera=$this->cnm_calamidad_model->getLastInserted('CNM_CARTERANOMISIONAL','COD_CARTERA_NOMISIONAL');


												$date = array(
												'FECHA_CREACION' =>  date("d/m/Y H:i:s"),
												'FECHA_SOLICITUD' =>  $this->input->post('fecha_solicitud'),
												'FECHA_RESOLUCION' =>  $this->input->post('fecha_resolucion'),
												'FECHA_ACTIVACION' =>  $this->input->post('fecha_activacion'),
												);

												$data = array(
																'COD_TIPO_TASA' => "",
																'COD_MODALIDAD' => $this->input->post('tipo_modalidad_id'),
																'NUM_RESOLUCION' => $this->input->post('numero_resolucion'),
																'PLAZO_CUOTAS' => $this->input->post('plazo'),			
																'FORMA_PAGO' => $this->input->post('forma_pago_id'),	
																'ID_CODEUDOR' => $this->input->post('id_codeudor'),	
																'NOMBRE_CODEUDOR' => $this->input->post('nombre_codeudor'),	
																'COD_CARTERA' => $id_cartera,
																'MOD_TASA_CORRIENTE' => $mod_tasa_corr,
																'MOD_TASA_MORA' => $mod_tasa_mora,
																													
												);
										
									if ($this->cnm_calamidad_model->add('CNM_CALAMIDAD_DOMESTICA',$data,$date) == TRUE)
									{
										trazarProcesoJuridico('545', '1356', '', '', $id_cartera, '', '', '', '','');
										$id_calamidad=$this->cnm_calamidad_model->getLastInserted('CNM_CALAMIDAD_DOMESTICA','COD_CARTERA_CALAMIDAD');
										if($this->input->post('tipo_estado_id')=='2')
										{
				$this->cnm_liquidacioncuotas = new Cnm_liquidacioncuotas();
                if($this->cnm_liquidacioncuotas->CnmCalcularCuotas($id_cartera, $this->input->post('fecha_activacion'), $this->input->post('forma_pago_id'))==true)		
				{	
					trazarProcesoJuridico('547', '1358', '', '', $id_cartera, '', '', '', '','');
					trazarProcesoJuridico('548', '1359', '', '', $id_cartera, '', '', '', '','');
				}
				else {
				}
																			
										}
										else{													
										$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La Nueva Cartera Calamidad Doméstica se creó con éxito.</div>');
				                        $datos = array('id_cartera'=>$id_cartera, 'tipo_cartera'=>'1');
						
            			 				$this->session->set_userdata('lolwut',$datos);			
										redirect(base_url().'index.php/carteranomisional/carga_archivo_cart/');
													}
										$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La Nueva Cartera Calamidad Doméstica se creó con éxito.</div>');
				                        $datos = array('id_cartera'=>$id_cartera, 'tipo_cartera'=>'1');
						
            			 				$this->session->set_userdata('lolwut',$datos);			
										redirect(base_url().'index.php/carteranomisional/carga_archivo_cart/');
									
									}
else {
	$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
	
}
									}
									else
									{
									
					$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';

									}
}
											else
											{
										$this->session->set_flashdata('message', '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>La Cedula del Empleado no existe en el sistema, ingrese un número de documento valido.</div>');
				        							redirect(base_url().'index.php/carteranomisional/add');												
											}


								}


										}

												
												
$id_cartera=$this->input->post('cod_cartera_calamidad');
$this->data['tipoCartera']  = $this->cnm_calamidad_model->tipoCartera($id_cartera);
$this->data['estado']  = $this->cnm_calamidad_model->selectTipoEstado();
$this->data['forma_pago']  = $this->cnm_calamidad_model->selectFormaPago();
$this->data['duracion']  = $this->cnm_calamidad_model->selectPlazo();
$this->data['acuerdos']  = $this->cnm_calamidad_model->selectAcuerdo($id_cartera);
if(!empty($this->data['acuerdos']->result_array[0]["COD_ACUERDOLEY"])){
$cod_ac_modalidad= $this->data['acuerdos']->result_array[0]["COD_ACUERDOLEY"];
}
else{
$cod_ac_modalidad= "";	
}
$this->data['acuerdo_prestamo']  = $cod_ac_modalidad;
$this->data['modalidad']  = $this->cnm_calamidad_model->selectModalidad($cod_ac_modalidad);
$this->data['tipotasa']  = $this->cnm_calamidad_model->selectTipoTasaCombo();
$this->data['tipotasaesp']  = $this->cnm_calamidad_model->selectTasaEspCombo();

							$this->template->load($this->template_file, 'cnm_calamidad/cnm_calamidad_add', $this->data);
								}
								else {
										$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
													redirect(base_url().'index.php/carteranomisional');
									 }
							 }
						else
						{
							redirect(base_url().'index.php/auth/login');
						}
		}	

		 function get_tipo_modalidad($acuerdo_id){

$tipo_modalidad = $this->cnm_calamidad_model->selectModalidad($acuerdo_id);

foreach ($tipo_modalidad->result_array as $data) {
	$tipo_mod_resp[$data["COD_MODALIDAD"]]=$data["NOMBRE_MODALIDAD"];
}	

print_r(json_encode($tipo_mod_resp));

}

function do_test()
{
    $config['upload_path'] = './uploads/fiscalizaciones';
    $config['allowed_types'] = 'gif|jpg|png|pdf';
  $config['max_size'] = '10000';

    $this->load->library('upload', $config);



if (!$this->upload->do_upload('userfile')) 
    {
        echo "no";
    }
    else
    {
        $data = array('upload_data' => $this->upload->data());

        echo "yes";
    }
}	

public function doUploadFile() {

        $status = '';
        $message = '';
        $background = '';
        $file_element_name = 'userFile';


 

   
            if ($status != 'error') {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'png|jpg|gif|pdf';
                $config['max_size'] = '10000';
                $config['overwrite'] = TRUE;
				 $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload($file_element_name)) {
return false;
                } else {
     $data = $this->upload->data();

                }
                @unlink($_FILES[$file_element_name]);
            }
        
        $json_encode = json_encode(array('message' => $message, 'status' => $status, 'background' => $background));
        echo $json_encode;
    }

	function edit(){    
				
			if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('carteranomisional/add'))
							 {
					$this->template->set('title', 'Edicion Cartera Calamidad Doméstica');

												
												$flag=$this->input->post('vista_flag');
										if(!empty($flag)){
											
										$this->form_validation->set_rules('cedula', 'Cedula', 'required');

												if ($this->form_validation->run() == false)
										{

												 $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>'.validation_errors().'</div>' : false);

										} else
										{
date_default_timezone_set("America/Bogota");
											$tasa_corriente=$this->input->post('t_i_c');
												if(!empty($tasa_corriente))
					{	$mod_tasa_corr='S';
						$calc_corriente= $this->input->post('combo_tipo_tasa_corriente');
						switch($calc_corriente)
						{case '1':
						$tipo_t_f_corriente= $this->input->post('aplica_tasa_c');
						$tipo_t_v_corriente= "";
						$valor_t_corriente= $this->input->post('porcent_tasa_c');
							break;
							
						case '2':
						$tipo_t_f_corriente= "";
						$tipo_t_v_corriente= $this->input->post('aplica_tasa_c');
						$valor_t_corriente= "";
							break;
							
						default:
						$tipo_t_f_corriente= "";
						$tipo_t_v_corriente= "";
						$valor_t_corriente= "";

						break;		
						}
						
						
					}
												else
													{
						$mod_tasa_corr='N';								
						$calc_corriente= "";
						$tipo_t_f_corriente= "";
						$tipo_t_v_corriente= "";
						$valor_t_corriente= "";
													}
													
													
								$tasa_mora=$this->input->post('t_i_m');
												if(!empty($tasa_mora))
					{
						$mod_tasa_mora='S';		
						$calc_mora= $this->input->post('combo_tipo_tasa_mora');
						switch($calc_mora)
						{case '1':
						$tipo_t_f_mora= $this->input->post('aplica_tasa_m');
						$tipo_t_v_mora= "";
						$valor_t_mora= $this->input->post('porcent_tasa_m');
							break;
							
						case '2':
						$tipo_t_f_mora= "";
						$tipo_t_v_mora= $this->input->post('aplica_tasa_m');
						$valor_t_mora= "";
							break;
							
						default:
						$tipo_t_f_mora= "";
						$tipo_t_v_mora= "";
						$valor_t_mora= "";

						break;		
						}
						
						
					}
												else
													{
						$mod_tasa_mora='N';									
						$calc_mora= "";
						$tipo_t_f_mora= "";
						$tipo_t_v_mora= "";
						$valor_t_mora= "";
													}
													
													$id_deuda = $this->input->post('id_deuda');
																	
												
												
																							$datecnm = array(
												'FECHA_CREACION' =>  date("d/m/Y H:i:s"),

												);

												$datacnm = array(
																'COD_TIPOCARTERA' => '1',
																'COD_PROCESO_REALIZADO' => '1',
																'COD_REGIONAL' => $this->ion_auth->user()->row()->COD_REGIONAL,
																'COD_EMPLEADO' => $this->input->post('cedula'),
																'COD_ESTADO' => $this->input->post('tipo_estado_id'),			
																'COD_TIPO_ACUERDO' => $this->input->post('tipo_acuerdo_id'),	
																'VALOR_DEUDA' => str_replace(".", "", $this->input->post('valor_deuda')),
																'SALDO_DEUDA' => str_replace(".", "", $this->input->post('valor_deuda')),
																'COD_FORMAPAGO' => $this->input->post('forma_pago_id'),	
																'PLAZO_CUOTAS' => $this->input->post('plazo'),
																'COD_PLAZO' => $this->input->post('plazo_id'),	
																'CALCULO_CORRIENTE' => $calc_corriente,
																'TIPO_T_F_CORRIENTE' => $tipo_t_f_corriente,
																'TIPO_T_V_CORRIENTE' => $tipo_t_v_corriente,
																'VALOR_T_CORRIENTE' => $valor_t_corriente,		
																'CALCULO_MORA' => $calc_mora,
																'TIPO_T_F_MORA' => $tipo_t_f_mora,
																'TIPO_T_V_MORA' => $tipo_t_v_mora,
																'VALOR_T_MORA' => $valor_t_mora,														
												);
												
												
									if ($this->cnm_calamidad_model->updateCartera('CNM_CARTERANOMISIONAL',$datacnm,$datecnm,$id_deuda,"COD_CARTERA_NOMISIONAL") == TRUE)
									{
										
												$date = array(

												'FECHA_SOLICITUD' =>  $this->input->post('fecha_solicitud'),
												'FECHA_RESOLUCION' =>  $this->input->post('fecha_resolucion'),
												'FECHA_ACTIVACION' =>  $this->input->post('fecha_activacion'),
												);

												$data = array(
																'COD_TIPO_TASA' => "",
																'MOD_TASA_CORRIENTE' => $mod_tasa_corr,
																'MOD_TASA_MORA' => $mod_tasa_mora,
																'COD_MODALIDAD' => $this->input->post('tipo_modalidad_id'),
																'NUM_RESOLUCION' => $this->input->post('numero_resolucion'),
																'PLAZO_CUOTAS' => $this->input->post('plazo'),			
																'FORMA_PAGO' => $this->input->post('forma_pago_id'),	
																'ID_CODEUDOR' => $this->input->post('id_codeudor'),	
																'NOMBRE_CODEUDOR' => $this->input->post('nombre_codeudor'),	
																													
												);
										
									if ($this->cnm_calamidad_model->updateCartera('CNM_CALAMIDAD_DOMESTICA',$data,$date,$id_deuda,"COD_CARTERA") == TRUE)
									{
											trazarProcesoJuridico('546', '1357', '', '', $id_deuda, '', '', '', '','');
					
											if($this->input->post('tipo_estado_id')=='2')
										{
				$this->cnm_liquidacioncuotas = new Cnm_liquidacioncuotas();
                if($this->cnm_liquidacioncuotas->CnmCalcularCuotas($id_deuda, $this->input->post('fecha_activacion'), $this->input->post('forma_pago_id'))==true)		
				{	trazarProcesoJuridico('547', '1358', '', '', $id_deuda, '', '', '', '','');
					trazarProcesoJuridico('548', '1359', '', '', $id_deuda, '', '', '', '','');
				}
				else {
				}
																			
										}
										else{		
										$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La Cartera Calamidad Doméstica ha sido editada con éxito.</div>');
				                         $datos = array('id_deuda'=>$id_deuda, 'tipo_cartera'=>'1', 'tabla_cartera'=>'CNM_CALAMIDAD_DOMESTICA');
										 
            			 				$this->session->set_userdata('lolwut',$datos);			
													redirect(base_url().'index.php/carteranomisional/carga_archivo_edit/');
}
										$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La Cartera Calamidad Doméstica ha sido editada con éxito.</div>');
				                         $datos = array('id_deuda'=>$id_deuda, 'tipo_cartera'=>'1', 'tabla_cartera'=>'CNM_CALAMIDAD_DOMESTICA');
										 
            			 				$this->session->set_userdata('lolwut',$datos);			
													redirect(base_url().'index.php/carteranomisional/carga_archivo_edit/');

									
									}
else {
	$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
	
}
									}
									else
									{
									
					$this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';

									}
								}


										}

												
												
$id_cartera_esp=$this->input->post('id_cartera_edit');

$id_cartera=1;
$this->data['detalleCart']  = $this->cnm_calamidad_model->detalleCarterasEdit($id_cartera_esp)->result_array[0];

$this->data['tipoCartera']  = $this->cnm_calamidad_model->tipoCartera($id_cartera);
$this->data['estado']  = $this->cnm_calamidad_model->selectTipoEstado();
$this->data['forma_pago']  = $this->cnm_calamidad_model->selectFormaPago();
$this->data['duracion']  = $this->cnm_calamidad_model->selectPlazo();
$this->data['acuerdos']  = $this->cnm_calamidad_model->selectAcuerdo($id_cartera);
if(!empty($this->data['detalleCart']["COD_TIPO_ACUERDO"])){
$cod_ac_modalidad= $this->data['detalleCart']["COD_TIPO_ACUERDO"];
}
else{
$cod_ac_modalidad= "";	
}
$this->data['acuerdo_prestamo']  = $cod_ac_modalidad;
$this->data['modalidad']  = $this->cnm_calamidad_model->selectModalidad($cod_ac_modalidad);
$this->data['tipotasa']  = $this->cnm_calamidad_model->selectTipoTasaCombo();
$this->data['tipotasaesp']  = $this->cnm_calamidad_model->selectTasaEspCombo();
$this->data['tipotasaespC']  = $this->cnm_calamidad_model->selectTasaEspComboEdit($this->data['detalleCart']["CALCULO_CORRIENTE"]);
$this->data['tipotasaespV']  = $this->cnm_calamidad_model->selectTasaEspComboEdit($this->data['detalleCart']["CALCULO_MORA"]);



//var_dump($this->data['detalleCart']);
//echo $id_cartera_esp;
//die();
							$this->template->load($this->template_file, 'cnm_calamidad/cnm_calamidad_edit', $this->data);
								}
								else {
										$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
													redirect(base_url().'index.php/carteranomisional');
									 }
							 }
						else
						{
							redirect(base_url().'index.php/auth/login');
						}
				
		}
	
		function delete(){
			
			
				 if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('fiscalizacion/delete'))
							 {
										$ID =  $this->uri->segment(3);
										if ($ID==""){
											$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>Debe Eliminar mediante edición.</div>');
													redirect(base_url().'index.php/fiscalizacion');
										}else{
											 $data = array(
                                    				'IDESTADO' => '2'

				                            	);
				           				if($this->fiscalizacion_model->edit('BANCO',$data,'IDBANCO',$ID) == TRUE){
												//$this->codegen_model->delete('BANCO','IDBANCO',$ID);             
												$this->template->set('title', 'Fiscalizacion');
												$this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>El banco se eliminó correctamente.'.$ID.'</div>');
												redirect(base_url().'index.php/fiscalizacion/');
										}
									}
								}else {
										$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
													redirect(base_url().'index.php/fiscalizacion');
									 }
					}else
						{
							redirect(base_url().'index.php/auth/login');
						}
		}



 
function detalle(){


    
				if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('carteranomisional/consulta'))
							 {
					$this->template->set('title', 'Consulta Cartera No Misional');
										//add style an js files for inputs selects

										
										$id_cartera=$this->input->post('id_cartera');
										//echo $id_cartera;
										//die();
										$this->data['carterasini']  = $this->cnm_calamidad_model->detalleprevioCalamidad($id_cartera)->result_array[0];
										//var_dump($this->data['carterasini']);			
										//die();	
										//echo $id_cartera;
										//die();					
										$this->data['carteras']  = $this->cnm_calamidad_model->detalleCalamidad($id_cartera, $this->data['carterasini']['COD_MODALIDAD'], $this->data['carterasini']['MOD_TASA_CORRIENTE'], $this->data['carterasini']['MOD_TASA_MORA'], $this->data['carterasini']['CALCULO_CORRIENTE'], $this->data['carterasini']['CALCULO_MORA'])->result_array[0];
										//var_dump($this->data['carteras']);
										//die();
										$consultaadj=$this->data['carteras']['ADJUNTOS'];
										
										
if(!empty($consultaadj)){
				$adjuntoconsulta = strpos($consultaadj, "::");

if ($adjuntoconsulta === false) {
	$this->data['lista_adjuntos'][0]=$consultaadj;	
} else {$cadena="";
	$stringadj=explode('::', $consultaadj);
	$this->data['lista_adjuntos']=$stringadj;
}	
				
				}
				else{
						
			$this->data['lista_adjuntos']="";		
				}
										
										
										$this->template->load($this->template_file, 'cnm_calamidad/cnm_calamidad_list', $this->data);
								}else {
										$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
													redirect(base_url().'index.php/carteranomisional');
									 }
							 }
						else
						{
							redirect(base_url().'index.php/auth/login');
						}
		}	

function lista(){


    
				if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('carteranomisional/consulta'))
							 {
					$this->template->set('title', 'Consulta Cartera No Misional');
										//add style an js files for inputs selects
										$this->load->library('datatables');	
										$this->data['style_sheets']= array(
														'css/jquery.dataTables_themeroller.css' => 'screen'
                
												);
										
										$id_cartera=$this->input->post('cartera_id');
										$cedula=$this->input->post('cedula');
										$estado=$this->input->post('estado');
										$id_deuda=$this->input->post('id_deuda');
										
										$this->data['carteras']  = $this->cnm_calamidad_model->detalleCarteras($cedula, $id_cartera, $estado, $id_deuda);
									

										
									$this->load->view('cnm_calamidad/cnm_calamidad_datos_consulta', $this->data);
								}else {
										$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
													redirect(base_url().'index.php/carteranomisional');
									 }
							 }
						else
						{
							redirect(base_url().'index.php/auth/login');
						}
		}	

function visualizar_pagos(){


    
				if ($this->ion_auth->logged_in())
					 {
								if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('carteranomisional/consulta'))
							 {

															
										$this->template->set('title', 'Consulta Cartera No Misional');
										
										$id_deuda=$this->input->post('id_deuda');

										
										$this->data['detalle_pagos']  = $this->cnm_calamidad_model->detallePagos($id_deuda);
										//var_dump($this->data['detalle_pagos']);
										//die();	
										$this->load->view('cnm_calamidad/cnm_calamidad_visualizar_pagos', $this->data);
								
							 
							 }else {
										$this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
													redirect(base_url().'index.php/carteranomisional');
									 }
							 }
						else
						{
							redirect(base_url().'index.php/auth/login');
						}
		}


  public function exportarxl() {
    if ($this->ion_auth->logged_in()) {
      if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('fiscalizacion/detalle_empresa_fiscalizar')) {
        	
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=ficheroExcel.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo utf8_decode($_POST['datos_envio']);
	  
	  } else {
        $this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
        redirect(base_url() . 'index.php/inicio');
      }
    } else {
      redirect(base_url() . 'index.php/auth/login');
    }
  }

   function traercedula() {
    if ($this->ion_auth->logged_in()) {
      if ($this->ion_auth->is_admin() || $this->ion_auth->in_menu('fiscalizacion/manage')) {
        $nit = $this->input->get('term');
        if (empty($nit)) {
          redirect(base_url() . 'index.php/cnm_calamidad/add');
        } else {
          $this->cnm_calamidad_model->set_nit($nit);
          return $this->output->set_content_type('application/json')->set_output(json_encode($this->cnm_calamidad_model->buscarnits()));
        }
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>No tiene permisos para acceder a esta área.</div>');
        redirect(base_url() . 'index.php/inicio');
      }
    } else {
      redirect(base_url() . 'index.php/auth/login');
    }
  }
   
   
   		 function get_datos($id){

$data_emp = $this->cnm_calamidad_model->select_data_emp($id);
//var_dump($data_emp);
//die();
print_r(json_encode($data_emp));

		} 		
}


