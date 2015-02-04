<?php

class Iconos extends MY_Controller {

  function __construct() {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->helper(array('form', 'url', 'codegen_helper'));
    $this->load->model('codegen_model', '', TRUE);
  }

  function index() {
    $this->manage();
  }

  function manage() {
    if ($this->ion_auth->is_admin()) {
      //template data
      $this->template->set('title', 'Iconos');
      $this->data['style_sheets'] = array(
          'css/jquery.dataTables_themeroller.css' => 'screen'
      );
      $this->data['javascripts'] = array(
          'js/jquery.dataTables.min.js',
          'js/jquery.dataTables.defaults.js'
      );
      $this->data['message'] = $this->session->flashdata('message');
      $this->template->load($this->template_file, 'iconos/iconos_list', $this->data);
    } else {
      redirect(base_url() . 'index.php/auth/login');
    }
  }

  function add() {
    if ($this->ion_auth->is_admin()) {
      $this->load->library('form_validation');
      $this->data['custom_error'] = '';
      $showForm = 0;
      $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim|xss_clean|max_length[48]');
      $this->form_validation->set_rules('traduccion', 'Traducción', 'required|trim|xss_clean|max_length[48]');
      if ($this->form_validation->run() == false) {
        $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>' . validation_errors() . '</div>' : false);
      } else {
        $data = array(
									'NOMBREICONO' => set_value('nombre'),
									'TRADUCCION' => set_value('traduccion'),
								);

        if ($this->codegen_model->add('ICONO', $data) == TRUE) {
          $this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La ícono se ha habilitado con éxito.</div>');
          redirect(base_url() . 'index.php/iconos/');
        } else {
          $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
        }
      }
      $this->template->load($this->template_file, 'iconos/iconos_add', $this->data);
    } else {
      redirect(base_url() . 'index.php/auth/login');
    }
  }

  function edit() {
    if ($this->ion_auth->is_admin()) {
      $this->load->library('form_validation');
      $this->data['custom_error'] = '';
      $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim|xss_clean|max_length[128]');
      $this->form_validation->set_rules('traduccion', 'Traducción', 'required|trim|xss_clean|max_length[128]');
      $this->form_validation->set_rules('estado_id', 'Estado', 'required|numeric|greater_than[0]');
      if ($this->form_validation->run() == false) {
        $this->data['custom_error'] = (validation_errors() ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>' . validation_errors() . '</div>' : false);
      } else {
        $data = array(
            'NOMBREICONO' => $this->input->post('nombre'),
            'TRADUCCION' => $this->input->post('traduccion'),
            'IDESTADO' => $this->input->post('estado_id')
        );

        if ($this->codegen_model->edit('ICONO', $data, 'IDICONO', $this->input->post('id')) == TRUE) {
          $this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La ícono se ha editado correctamente.</div>');
          redirect(base_url() . 'index.php/iconos/');
        } else {
          $this->data['custom_error'] = '<div class="error"><p>Ha ocurrido un error</p></div>';
        }
      }
      $this->data['result'] = $this->codegen_model->get('ICONO', 'IDICONO,NOMBREICONO,TRADUCCION', 'IDICONO = ' . $this->uri->segment(3), 1, 1, true);
      $this->template->load($this->template_file, 'iconos/iconos_edit', $this->data);
    } else {
      redirect(base_url() . 'index.php/auth/login');
    }
  }

  function delete() {
    if ($this->ion_auth->is_admin()) {
      $ID = $this->uri->segment(3);
      $this->codegen_model->delete('ICONO', 'IDICONO', $ID);
      $this->template->set('title', 'Iconos');
      $this->session->set_flashdata('message', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La ícono se eliminó correctamente.</div>');
      redirect(base_url() . 'index.php/iconos/');
    } else {
      redirect(base_url() . 'index.php/auth/login');
    }
  }

  function datatable() {
    if ($this->ion_auth->is_admin()) {
      $this->load->library('datatables');
      $this->datatables->select('ICONO.IDICONO,ICONO.TRADUCCION,ICONO.NOMBREICONO');
      $this->datatables->from('ICONO');
      $this->datatables->edit_column('img', '<i class="fa fa-$1 fa-lg"></i>', 'ICONO.NOMBREICONO');
      $this->datatables->add_column('edit', '<div class="btn-toolbar">
																							<div class="btn-group">
																								<a href="' . base_url() . 
																								'index.php/iconos/edit/$1" class="btn btn-small" title="Editar">
																								<i class="icon-edit"></i>
																								</a>
																							</div>
																						 </div>', 'ICONO.IDICONO');
      echo $this->datatables->generate();
    } else {
      redirect(base_url() . 'index.php/auth/login');
    }
  }

}

/* End of file categorias.php */
/* Location: ./system/application/controllers/categorias.php */