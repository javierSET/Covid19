<div id="back"></div>

<div class="login-box">

  <div class="login-logo">

    <img src="vistas/img/cns/cns-logo.png" class="img-fluid" style="padding: 0px 50px 0px 50px">

  </div>

  <div class="card">
  
    <div class="card-body login-card-body">
      
      <p class="login-box-msg">CNS Regional Cochabamba | COVID-19</p>

      <form method="post" autocomplete="off">
        
        <div class="input-group mb-3">

          <input type="text" class="form-control" id="Matricula" placeholder="Ingrese Matrícula" name="loginMatricula" required>

          <div class="input-group-append">

            <div class="input-group-text">

              <span class="fas fa-user"></span>

            </div>

          </div>

        </div>

        <div class="input-group mb-3">

          <input type="text" class="form-control" id="ci" placeholder="Ingrese Nro. CI" name="loginCI" required>

          <div class="input-group-append">

            <div class="input-group-text">

              <span class="fas fa-user"></span>

            </div>

          </div>

        </div>

        <div class="input-group mb-3">

           <input type="password" class="form-control" id="password" placeholder="Ingrese Contraseña" name="loginPassword" required>

          <div class="input-group-append">

            <div class="input-group-text">

              <span class="fas fa-lock"></span>

            </div>

          </div>

        </div>

        <div class="row">

          <div class="col-4">

            <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
          
          </div>
          
        </div>

        <?php 

          $login = new ControladorUsuarios();
          $login -> ctrIngresoUsuario();

        ?>
      
      </form>   
      
    </div>

  </div>

</div>