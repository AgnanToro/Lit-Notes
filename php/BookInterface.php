<?php
namespace Perpus;

interface BookInterface {
    public function getJudul();
    public function getPenulis();
    public function getTahunTerbit();
    public function getGambar();
}