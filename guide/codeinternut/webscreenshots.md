# WEB SCREENSHOTS

Pacotes Necessários

python-qt4 libqt4-webkit python-pip xvfb

Instalando Pacotes no Ubuntu
~~~
$ sudo apt-get install python-qt4 libqt4-webkit python-pip xvfb
~~~

Baixando o arquivo que executa o script 
~~~
$ sudo wget https://raw.github.com/millisami/python-webkit2png/master/webkit2png.py
~~~

Dar permissão de execução no arquivo
~~~
$ sudo chmod +x webkit2png
~~~

## Exemplo

~~~
$ sudo xvfb-run --server-args="-screen 0, 1024x768x24" ./webkit2png.py -o google.png http://www.google.com
~~~

### Referencia

https://github.com/millisami/python-webkit2png