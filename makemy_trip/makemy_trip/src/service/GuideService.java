/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package service;


import entite.guide_touristique;
import utils.Connection_joy;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.util.regex.Pattern;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

/**
 *
 * @author Oussama JAOUADI
 */
public class GuideService implements Makemytrip_service <guide_touristique>{
        private Connection conn;
        private PreparedStatement pst;
         private ResultSet rs;
         private Statement ste; 
         
         
         public GuideService() {
        conn = Connection_joy.getInstance().getCnx();
    }
         @Override
    	public void insert(guide_touristique h) {
        String req = "insert into guide_touristique (nom,prenom,adresse,telephone,email,diplome) values (?,?,?,?,?,?)";
        try {
        	
        	
            pst = conn.prepareStatement(req);
            pst.setString(1, h.getNom());
            pst.setString(2, h.getPrenom());
            pst.setString(3, h.getAdresse());
            pst.setInt(4, h.getTelephone());
            
         
            	
            	pst.setString(5, h.getEmail());
            pst.setString(6, h.getDiplome());
        
 
            pst.executeUpdate();

        } catch (Exception ex) {
            Logger.getLogger(GuideService.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    public int getGuideTourisque(guide_touristique h){
        String req="select * from guide_touristique where nom=? and adresse=?";
        List<guide_touristique> list=new ArrayList<>();
        int x=0;
         try {
             pst = conn.prepareStatement(req);
             pst.setString(1, h.getNom());
             pst.setString(2, h.getAdresse());
             rs=pst.executeQuery();
             
             while(rs.next()){
                list.add(new guide_touristique(rs.getInt("id_guide"), rs.getString("nom"), rs.getString("adresse"),rs.getString("prenom"),rs.getInt("telephone"),rs.getString("email"),rs.getString("diplome")));
                x=list.get(0).getId_guide();
            }
         } catch (SQLException ex) {
             Logger.getLogger(GuideService.class.getName()).log(Level.SEVERE, null, ex);
         }
        return x;   
    }
    
    public void delete(int id) {
    	
    	 try {
             Statement stm=conn.createStatement();
             String query="delete from guide_touristique where id_guide = '"+id+"'";
            
             stm.executeUpdate(query);
             System.out.println("guide with id "+id+" deleted"); 
             
        } catch (SQLException ex) {
            Logger.getLogger(GuideService.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    public void delete(guide_touristique h) {
        String req ="delete from guide_touristique WHERE nom=? and adresse=? ";
        {
            try {
            pst = conn.prepareStatement(req);
            pst.setString(1, h.getNom());
            pst.setString(2, h.getAdresse());         
            pst.executeUpdate();
            System.out.println("deleted succefully");

        } catch (SQLException ex) {
            Logger.getLogger(GuideService.class.getName()).log(Level.SEVERE, null, ex);
        }
        
        
        
        }
    }
     
    

    @Override
    public void update(guide_touristique h , int id   ) {
          
            String req = "UPDATE guide_touristique SET nom =? , prenom= ?, adresse= ?, telephone=?, email=? WHERE id_guide='"+id+"' ";
        {
        try{
            
            pst = conn.prepareStatement(req);
            pst.setString(1, h.getNom());
            pst.setString(2, h.getPrenom());
            pst.setString(3, h.getAdresse());
            pst.setInt(4, h.getTelephone());
            pst.setString(5, h.getEmail());
            pst.executeUpdate();
            System.out.println("updated succefuly...");
            }
        catch (SQLException ex) {
            Logger.getLogger(GuideService.class.getName()).log(Level.SEVERE, null, ex);
        }
        }
    }

    
    
     public int getid_guide_db(guide_touristique g){
        String req="select * from guide_touristique where Nom=? and Adresse=?";
        List<guide_touristique> list=new ArrayList<>();
        int x=0;
         try {
             pst = conn.prepareStatement(req);
             pst.setString(1, g.getNom());
             pst.setString(2, g.getAdresse());
             rs=pst.executeQuery();
             while(rs.next()){
                list.add(new guide_touristique(rs.getInt("id_guide"), rs.getString("nom"), rs.getString("adresse"),rs.getString("email"),rs.getInt("telephone"),rs.getString("prenom"),rs.getString("diplome")));
                x=list.get(0).getId_guide();
            }
         } catch (SQLException ex) {
             Logger.getLogger(GuideService.class.getName()).log(Level.SEVERE, null, ex);
         }
        return x;   
     }
     
     
public List <guide_touristique> readAll()
    {
    	String req = "select * from guide_touristique"; 
    	List <guide_touristique> list = new ArrayList<>(); 
    	try {
    		ste = conn.createStatement(); 
    		rs=ste.executeQuery(req); 
            System.out.println("Affichage :");

    		while(rs.next())
    		{

                list.add(new guide_touristique(rs.getInt("id_guide"), rs.getString("Nom"), rs.getString("prenom"),rs.getString("Adresse"),rs.getInt("telephone"),rs.getString("email"),rs.getString("diplome")));
    		}
    			System.out.print(list);
    	}
    	catch(SQLException ex){
    		Logger.getLogger(GuideService.class.getName()).log(Level.SEVERE, null, ex);
    	}
        return list; 
    }

public ObservableList<guide_touristique> getAll() throws SQLException
{
    ObservableList<guide_touristique> guideList = FXCollections.observableArrayList(); 
    
     List <guide_touristique> id_guide = new ArrayList<>(); 
        ste = conn.createStatement();
        String query = "select id_guide, Nom, prenom, Adresse, telephone,email, diplome from guide_touristique";

        //ResultSet rs;
        rs = ste.executeQuery(query);
        guide_touristique guide_touristique;
        while (rs.next()) {
           guide_touristique= new guide_touristique(rs.getInt("id_guide"), rs.getString("Nom"), rs.getString("prenom"),rs.getString("Adresse"),rs.getInt("telephone"),rs.getString("email"),rs.getString("diplome"));
            //System.out.println(events);
            guideList.add(guide_touristique);

        }
        return guideList;
    
}

public ObservableList<guide_touristique> getAll(String search) throws SQLException
{
    ObservableList<guide_touristique> guideList = FXCollections.observableArrayList(); 
    
     List <guide_touristique> id_guide = new ArrayList<>(); 
        ste = conn.createStatement();
        String query = "select id_guide, Nom, prenom, Adresse, telephone,email, diplome from guide_touristique WHERE Nom LIKE '%" + search + "%' \n" +
"        OR prenom LIKE '%" + search + "%' \n" +
"        OR Adresse LIKE '%" + search + "%'  \n" +
"        OR telephone LIKE '%" + search + "%'  \n" +
"        OR email LIKE '%" + search + "%'";

        //ResultSet rs;
        rs = ste.executeQuery(query);
        guide_touristique guide_touristique;
        while (rs.next()) {
           guide_touristique= new guide_touristique(rs.getInt("id_guide"), rs.getString("Nom"), rs.getString("prenom"),rs.getString("Adresse"),rs.getInt("telephone"),rs.getString("email"),rs.getString("diplome"));
            //System.out.println(events);
            guideList.add(guide_touristique);

        }
        return guideList;
    
}
    


	@Override
    public List<guide_touristique> read() {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }

    @Override
    public guide_touristique readById(int id) {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }

    @Override
    public void update(guide_touristique t) {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }
	



   

    
}
