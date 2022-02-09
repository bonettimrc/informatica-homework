<?php
namespace test;
class DbManager {
    /**il nome server che ospita il motore/driver MySQL*/
    private static $host;
    /**la porta utilizzata per il servizio MySQL*/
    private static $port;
    /**lo username/user id assegnato all’istanza MySQL per la Azure Service App in uso*/
    private static $username;
    /**la password associata allo username*/
    private static $password;
    /**
     * Estrae dalla variabile di sistema "MYSQLCONNSTR_localdb" le informazioni utili per l’accesso e la manipolazione dei
     *database presenti sul server.
     */
    private static function init()
    {
        $string = getenv("MYSQLCONNSTR_localdb");
        $array = array();
        foreach( explode( ';', $string ) as $substr )
        {
            $exploded = explode('=', $substr);
            $array[ $exploded[0] ] = $exploded[1];
        }
        self::$host = $array["Database"];
        self::$port = $array["Data Source"];
        self::$username = $array["User"];
        self::$password = $array["Password"];
    }
    /**
     * Se l’inizializzazione non è ancora avvenuta viene prima eseguito il metodo “init”.
     *restituisce il nome del server che ospita il driver MySQL memorizzato nella variabile “host”.
     */
    public static function getHost() {
        if(!isset(self::$host)){
            self::init();
        }
        return self::$host;
    }
    /**
     * Se l’inizializzazione non è ancora avvenuta viene prima eseguito il metodo “init”.
     *restituisce il numero della porta utilizzata sul server per il servizio MySQL.
     */
    public static function getPort() {
        if(!isset(self::$port)){
            self::init();
        }
        return self::$port;
    }
    /**
     * Se l’inizializzazione non è ancora avvenuta viene prima eseguito il metodo “init”.
     *restituisce lo username associato all’istanza MySQL memorizzato nella variabile “username”.
     */
    public static function getUsername() {
        if(!isset(self::$username)){
            self::init();
        }
        return self::$username;
    }
    /**
     * Se l’inizializzazione non è ancora avvenuta viene prima eseguito il metodo “init”.
     *restituisce la password associata all’istanza MySQL memorizzata nella variabile “password”.
     */
    public static function getPassword() {
        if(!isset(self::$password)){
            self::init();
        }
        return self::$password;
    }
    /**
     * tenta la connessione al database specificato, restituendo il riferimento all’oggetto PDO istanziato.
     *Genera un’eccezione in caso di errore.
     */
    public static function connect($dbName)  {
        return new PDO("mysql:host=".self::$serverName.";dbname=".self::$dbName,self::$username, self::$password);
    }
    /**
     * tenta la connessione al database specificato, restituendo il riferimento all’oggetto PDO istanziato, oppure null se
     *fallisce.
     *NON GENERA ECCEZIONI
    */
    public static function connectS($dbName){
        try {
            return self::connect($dbName);
        } catch (PDOException $ex) {
            return null;
        }
    }
    /** esegue l’interrogazione SQL indicata in $sqlCommand tramite l’oggetto $pdo, restituendo un array con l’insieme
    * dei record che soddisfano l’interrogazione, oppure un array vuoto se non vi sono corrispondenze.
    * Il comando può prevedere segnaposti para+metrici (posizionali o denominati), in questo caso vanno forniti con il
    * parametro $parameters, un array semplice nel caso di parametri posizionali, un array associativo nel caso di
    * parametri denominati.
    * I risultati vengono forniti sotto forma di:
    * • array bidimensionale ($resultAsObject=false) PREDEFINITO
    * ogni record/riga restituita è un array indicizzato sia per nome colonna che per indice (PDO::FETCH_BOTH)
    * • array di oggetti anonimi ($resultAsObject=true e $className=null)
    * ogni record/riga restituita è un oggetto con proprietà che corrispondono ai nomi delle colonne selezionate
    * (PDO::FETCH_OBJ)
    * • array di oggetti di una classe specifica ($resultAsObject=true e $className=nome_classe)
    * ogni record/riga restituita è un oggetto del tipo corrispondente alla classe specificata, con proprietà che
    * corrispondono ai nomi delle colonne selezionate (PDO::FETCH_CLASS)
    * Genera un’eccezione in caso di errore.
    */
    public static function select(PDO $pdo, $sqlCommand, $parameters=null,$resultAsObject=false, $className=null):array{
        $statement = $pdo->prepare($sqlCommand);
        $statement->execute();
        $FETCH_MODE = PDO::FETCH_BOTH;
        if($resultAsObject){
            $FETCH_MODE = PDO::FETCH_OBJ;
            if(isset($className)){
                $FETCH_MODE = PDO::FETCH_CLASS;
            }
        }
        $results = $statement->fetchAll($FETCH_MODE);
        return $results;
    }
    /** come select, ma restituisce null in caso di errore.
    *NON GENERA ECCEZIONI */
    public static function selectS($pdo, $sqlCommand, $parameters=null, $resultAsObject=false, $className=null) : array{
        try {
            return self::select($pdo, $sqlCommand, $parameters=null, $resultAsObject=false, $className=null);
        } catch (PDOException $ex) {
            return null;
        }
    }
    /**
     * Esegue il comando SQL indicato in $sqlCommand tramite l’oggetto $pdo, restituendo il numero di record
    * effettivamente modificati, il comando può corrispondere ad un INSERT, UPDATE o DELETE.
    * Il comando può prevedere segnaposti parametrici (posizionali o denominati), in questo caso vanno forniti con il
    * parametro $parameters, un array semplice nel caso di parametri posizionali, un array associativo nel caso di
    * parametri denominati.
    * Genera un’eccezione in caso di errore.
    */
    public static function execute($pdo, $sqlCommand, $parameters=null) : int {
        $statement = $pdo->prepare($sqlCommand);
        $statement->execute($parameters);
        $result = $statement->fetchAll();
        return $result;
    }
    /**
     * come execute, ma restituisce -1 in caso di errore.
     * NON GENERA ECCEZIONI
     */
    public static function executeS($pdo, $sqlCommand, $parameters=null) : int{
        try {
            return self::execute($pdo, $sqlCommand, $parameters);
        } catch (PDOException $ex) {
            return -1;
        }
    }

}
?>