/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package utils;

import java.sql.Connection;

/**
 *
 * @author Amine JAOUADI
 */
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;



public class Connection_joy {
    
    private  String url="jdbc:mysql://localhost:3306/makemy_trip";
    private  String login="root";
    private  String Pwd="";
    private  Connection cnx ;
    private static Connection_joy instance ;
    
    
    
    public Connection_joy() throws SQLException {
        
    

        cnx=DriverManager.getConnection(url, login, Pwd);
        System.out.println("Connexion etablie");
        }
    
    public static Connection_joy getInstance() {
        if (instance==null)
            try {
                instance=new Connection_joy();
        } catch (SQLException ex) {
            Logger.getLogger(Connection_joy.class.getName()).log(Level.SEVERE, null, ex);
        }
        return instance ;
    
    
    
    }

    public Connection getCnx() {
        return cnx;
    }
    
    
}
