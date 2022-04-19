/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package entite;

import java.io.Serializable;
import java.util.Date;
import javax.persistence.Basic;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.NamedQueries;
import javax.persistence.NamedQuery;
import javax.persistence.Table;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;

/**
 *
 * @author Jaouadi Oussama
 */
@Entity
@Table(name = "vol")
@NamedQueries({
    @NamedQuery(name = "Vol.findAll", query = "SELECT v FROM Vol v"),
    @NamedQuery(name = "Vol.findByIdVol", query = "SELECT v FROM Vol v WHERE v.idVol = :idVol"),
    @NamedQuery(name = "Vol.findByD\u00e9part", query = "SELECT v FROM Vol v WHERE v.d\u00e9part = :d\u00e9part"),
    @NamedQuery(name = "Vol.findByDestination", query = "SELECT v FROM Vol v WHERE v.destination = :destination"),
    @NamedQuery(name = "Vol.findByDateD\u00e9part", query = "SELECT v FROM Vol v WHERE v.dateD\u00e9part = :dateD\u00e9part"),
    @NamedQuery(name = "Vol.findByDateRetour", query = "SELECT v FROM Vol v WHERE v.dateRetour = :dateRetour"),
    @NamedQuery(name = "Vol.findByNbEscales", query = "SELECT v FROM Vol v WHERE v.nbEscales = :nbEscales"),
    @NamedQuery(name = "Vol.findByPrix", query = "SELECT v FROM Vol v WHERE v.prix = :prix")})
public class Vol implements Serializable {

    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id_vol")
    private Integer idVol;
    @Basic(optional = false)
    @Column(name = "d\u00e9part")
    private String départ;
    @Basic(optional = false)
    @Column(name = "destination")
    private String destination;
    @Basic(optional = false)
    @Column(name = "date_d\u00e9part")
    @Temporal(TemporalType.DATE)
    private Date dateDépart;
    @Basic(optional = false)
    @Column(name = "date_retour")
    @Temporal(TemporalType.DATE)
    private Date dateRetour;
    @Basic(optional = false)
    @Column(name = "nb_escales")
    private int nbEscales;
    @Basic(optional = false)
    @Column(name = "prix")
    private double prix;

    public Vol() {
    }

    public Vol(Integer idVol) {
        this.idVol = idVol;
    }

    public Vol(Integer idVol, String départ, String destination, Date dateDépart, Date dateRetour, int nbEscales, double prix) {
        this.idVol = idVol;
        this.départ = départ;
        this.destination = destination;
        this.dateDépart = dateDépart;
        this.dateRetour = dateRetour;
        this.nbEscales = nbEscales;
        this.prix = prix;
    }

    public Integer getIdVol() {
        return idVol;
    }

    public void setIdVol(Integer idVol) {
        this.idVol = idVol;
    }

    public String getDépart() {
        return départ;
    }

    public void setDépart(String départ) {
        this.départ = départ;
    }

    public String getDestination() {
        return destination;
    }

    public void setDestination(String destination) {
        this.destination = destination;
    }

    public Date getDateDépart() {
        return dateDépart;
    }

    public void setDateDépart(Date dateDépart) {
        this.dateDépart = dateDépart;
    }

    public Date getDateRetour() {
        return dateRetour;
    }

    public void setDateRetour(Date dateRetour) {
        this.dateRetour = dateRetour;
    }

    public int getNbEscales() {
        return nbEscales;
    }

    public void setNbEscales(int nbEscales) {
        this.nbEscales = nbEscales;
    }

    public double getPrix() {
        return prix;
    }

    public void setPrix(double prix) {
        this.prix = prix;
    }

    @Override
    public int hashCode() {
        int hash = 0;
        hash += (idVol != null ? idVol.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof Vol)) {
            return false;
        }
        Vol other = (Vol) object;
        if ((this.idVol == null && other.idVol != null) || (this.idVol != null && !this.idVol.equals(other.idVol))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return idVol + " : " + départ + "->" + destination;// entite.Vol[ idVol=" + idVol + " ]";
    }
    
}
