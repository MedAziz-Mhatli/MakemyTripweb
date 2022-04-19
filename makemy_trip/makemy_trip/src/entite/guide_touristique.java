package entite;

//class guide_touristique



import java.util.Objects;

/**
*
* @author jaouadi oussama
*/
public class guide_touristique {
   private int id_guide ;
   private  String Nom;
   private  String  prenom;
   private  String  Adresse;
   private  int  telephone;
   private  String  email;
   private  String  diplome;
   public static String pathfile; 
   public static String filename="";
   

   public guide_touristique(int id_guide, String Nom, String prenom, String Adresse, int telephone, String email, String diplome) {
      this.id_guide = id_guide;
      this.Nom = Nom;
      this.prenom = prenom;
      this.Adresse = Adresse;
      this.telephone = telephone;
      this.email = email;
      this.diplome = diplome;
      
  }

   public guide_touristique(String Nom, String prenom, String Adresse, int telephone, String email, String diplome) {
	     this.Nom = Nom;
	      this.prenom = prenom;
	      this.Adresse = Adresse;
	      this.telephone = telephone;
	      this.email = email;
	      this.diplome = diplome;
  }
   public guide_touristique(String Nom, String prenom, String Adresse, int telephone, String email)
   {
       this.Nom= Nom; 
       this.prenom=prenom; 
       this.Adresse=Adresse; 
       this.telephone=telephone; 
       this.email=email;
   }
   

  public guide_touristique(int aInt, String string, float aFloat, int aInt0) {
      throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
  }

  

  public int getId_guide() {
      return id_guide;
  }

  public String getNom() {
      return Nom;
  }

  public String getAdresse() {
      return Adresse;
  }

  public String getEmail() {
      return email;
  }

  public int getTelephone() {
      return telephone;
  }

  public String getPrenom() {
      return prenom;
  }

  public String getDiplome() {
      return diplome;
  }

  

  public void setid_guide(int id_guide) {
      this.id_guide = id_guide;
  }

  public void setNom(String Nom) {
      this.Nom = Nom;
  }

  public void setAdresse(String Adresse) {
      this.Adresse = Adresse;
  }

  public void setemail(String email) {
      this.email = email;
  }

  public void settelephone(int telephone) {
      this.telephone = telephone;
  }

  public void setprenom(String prenom) {
      this.prenom = prenom;
  }

  public void setdiplome(String diplome) {
      this.diplome = diplome;
  }

  
  
 

  @Override
  public boolean equals(Object obj) {
      if (this == obj) {
          return true;
      }
      if (obj == null) {
          return false;
      }
      if (getClass() != obj.getClass()) {
          return false;
      }
      final guide_touristique other = (guide_touristique) obj;
      if (this.id_guide != other.id_guide) {
          return false;
      }
      if (!Objects.equals(this.Nom, other.Nom)) {
          return false;
      }
      return true;
  }

  @Override
  public String toString() {
      //return "guide_touristique{" + "id_guide=" + id_guide + ", Nom=" + Nom + ", Adresse=" + Adresse + ", email=" + email + ", telephone=" + telephone + ", prenom=" + prenom + ", diplome=" + diplome + '}';
      return id_guide + " : " + prenom + " " + Nom;
  }

    public int getid_guide_db(guide_touristique g) {
        throw new UnsupportedOperationException("Not supported yet."); // Generated from nbfs://nbhost/SystemFileSystem/Templates/Classes/Code/GeneratedMethodBody
    }

    public void update(guide_touristique g1, int x) {
        throw new UnsupportedOperationException("Not supported yet."); // Generated from nbfs://nbhost/SystemFileSystem/Templates/Classes/Code/GeneratedMethodBody
    }
}
