/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package service;

import entite.guide_touristique;
import java.util.List;

/**
 *
 * @author oussama JAOUADI
 */
public interface Makemytrip_service <T> { // interface generique : 
    
    void insert(T t) throws Exception;
	   public void update(T t , int id   );
	   void delete(int id); 
	   void update(T t);
	    List<T>read();
    
    T readById(int id);
    
}
