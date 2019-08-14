<?php

class Autoload
{
  protected $baseDir;

  protected $map;

  /**
   * @param string $alias
   * @param string $path
   * @return $this
   */
  protected function setPath($alias, $path): self
  {
    $this->map[$alias[0]][$alias] = $path;
    return $this;
  }

  public function __construct($paths)
  {
    $this->baseDir = __DIR__ . '/../';

    foreach($paths as $alias => $path) {
      $this->setPath($alias, $path);
    }
  }

  protected function findFile($class): ?string
  {
    $classPath = strtr($class, '\\', DIRECTORY_SEPARATOR) . '.php';

    $first = $class[0];
    if (isset($this->map[$first])){
      $subAlias = $class;
      while($lastPos = strrpos($subAlias, '\\')){
        $subAlias = substr($subAlias, 0, $lastPos);
        if (isset($this->map[$first][$subAlias . '\\']) && file_exists($pathFile = $this->baseDir . DIRECTORY_SEPARATOR . $this->map[$first][$subAlias . '\\'] . substr($classPath, strlen($subAlias) + 1))){
          return $pathFile;
        }
      }
    }

    if (file_exists($pathFile = $this->baseDir . DIRECTORY_SEPARATOR . $classPath))
      return $pathFile;

    return null;
  }

  public function loader($class)
  {
    if ($path = $this->findFile($class))
      includeFile($path);
  }

  public function register()
  {
    spl_autoload_register([$this, 'loader']);
  }
}

/**
 * Scope isolated include
 * @param string $file
 */
function includeFile($file)
{
  require_once $file;
}