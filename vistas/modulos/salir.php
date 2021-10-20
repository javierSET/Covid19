<?php

unset($_SESSION["iniciarSesionCOVID"]);
unset($_SESSION["idUsuarioCOVID"]);
unset($_SESSION["paternoUsuarioCOVID"]);
unset($_SESSION["maternoUsuarioCOVID"]);
unset($_SESSION["nombreUsuarioCOVID"]);
unset($_SESSION["MatriculaUsuarioCOVID"]);
unset($_SESSION["fotoUsuarioCOVID"]);
unset($_SESSION["perfilUsuarioCOVID"]);

session_destroy();

echo '<script>

	localStorage.clear();

	window.location = "inicio";

</script>';	