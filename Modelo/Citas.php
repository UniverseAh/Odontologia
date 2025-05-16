<?php
class Cita
{
    private $numero;
    private $fecha;
    private $hora;
    private $paciente;
    private $medico;
    private $consultorio;
    private $estado;
    private $observaciones;
    public function __construct($num, $fec, $hor, $pac, $med, $con, $est, $obs)
    {
        $this->numero = $num;
        $this->fecha = $fec;
        $this->hora = $hor;
        $this->paciente = $pac;
        $this->medico = $med;
        $this->consultorio = $con;
        $this->estado = $est;
        $this->observaciones = $obs;
    }
    public function obtenerNumero()
    {
        return $this->numero;
    }
    public function obtenerFecha()
    {
        return $this->fecha;
    }
    public function obtenerHora()
    {
        return $this->hora;
    }
    public function obtenerPaciente()
    {
        return $this->paciente;
    }
    public function obtenerMedico()
    {
        return $this->medico;
    }
    public function obtenerConsultorio()
    {
        return $this->consultorio;
    }
    public function obtenerEstado()
    {
        return $this->estado;
    }
    public function obtenerObservaciones()
    {
        return $this->observaciones;
    }
}
