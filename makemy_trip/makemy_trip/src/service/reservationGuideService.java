package service;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;

import entite.guide_touristique;
import entite.reservation_guide;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import utils.Connection_joy;

public class reservationGuideService implements IreservationGuide <reservation_guide>{
	
	  private Connection conn;
      private PreparedStatement pst;
       private ResultSet rs;
       private Statement ste; 
     
       
       public reservationGuideService() {
      conn = Connection_joy.getInstance().getCnx();
       	}
       
     
	@Override
	public void insert(reservation_guide t) {
		
		String req = "insert into reservation_guide (id_guide,id_resGuide,id_resVol) values (?,?,?)";
        try {
            pst = conn.prepareStatement(req);
            pst.setInt(1,t.getId_guide()); 
            pst.setInt(2, t.getId_resGuide()); 
            pst.setInt(3,t.getId_resVol());
            pst.executeUpdate();

        } catch (SQLException ex) {
            Logger.getLogger(reservationGuideService.class.getName()).log(Level.SEVERE, null, ex);
        }
		
	}

	public void update(reservation_guide t, int id) {
	    String req = "UPDATE reservation_guide SET id_guide =?, id_resVol=?  WHERE id_resGuide='"+id+"' ";
        {
        try{
            
            pst = conn.prepareStatement(req);
            pst.setInt(1, t.getId_guide());
            pst.setInt(2, t.getId_resVol());
            pst.executeUpdate();
            System.out.println("updated succefuly...");
            }
        catch (SQLException ex) {
            Logger.getLogger(reservationGuideService.class.getName()).log(Level.SEVERE, null, ex);
        }
        }
		
	}

	@Override
	public void delete(int id) {
		 try {
             Statement stm=conn.createStatement();
             String query="delete from reservation_guide where id_resGuide = '"+id+"'";
            
             stm.executeUpdate(query);
             System.out.println("reservation guide with id "+id+" deleted"); 
             
        } catch (SQLException ex) {
            Logger.getLogger(reservationGuideService.class.getName()).log(Level.SEVERE, null, ex);
        }
		
	}
        
         public void delete(reservation_guide h) {
        String req ="delete from reservation_guide WHERE id_guide=? and id_resVol=? ";
        {
            try {
            pst = conn.prepareStatement(req);
            pst.setInt(1, h.getId_guide());
            pst.setInt(2, h.getId_resVol());        
            pst.executeUpdate();
            System.out.println("deleted succefully");

        } catch (SQLException ex) {
            Logger.getLogger(GuideService.class.getName()).log(Level.SEVERE, null, ex);
        }
        
        
        
        }
    }
         
         
         
         public ObservableList<reservation_guide> getAll() throws SQLException
{
    ObservableList<reservation_guide> guideList = FXCollections.observableArrayList(); 
    
     List <reservation_guide> id_resGuide = new ArrayList<>(); 
        ste = conn.createStatement();
        String query = "select id_resGuide, id_guide, id_resVol from reservation_guide";

        //ResultSet rs;
        rs = ste.executeQuery(query);
        reservation_guide reservation_guide;
        while (rs.next()) {
           reservation_guide= new reservation_guide(rs.getInt("id_resGuide"), rs.getInt("id_guide"), rs.getInt("id_resVol"));
            //System.out.println(events);
            guideList.add(reservation_guide);

        }
        return guideList;
    
}
        
        
        
        
        
        
        
        
        
	
    public List <reservation_guide> readAll()
    {
	String req = "select * from reservation_guide"; 
	List <reservation_guide> list = new ArrayList<>(); 
	try {
		ste = conn.createStatement(); 
		rs=ste.executeQuery(req); 
		
        System.out.println("Affichage :");

		while(rs.next())
		{

            list.add(new reservation_guide(rs.getInt("id_resGuide"),rs.getInt("id_guide"),rs.getInt("id_resVol")));
            
		}
            System.out.println(list);     		

		
	}
		catch(SQLException ex){
			Logger.getLogger(reservationGuideService.class.getName()).log(Level.SEVERE, null, ex);
		}
	    return list; 
	
    }
    
    

	
	
    
}
