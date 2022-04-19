package makemy_trip;


import java.io.File;
import entite.guide_touristique;
import entite.reservation_guide;
import net.sourceforge.tess4j.Tesseract;
import net.sourceforge.tess4j.TesseractException;
import service.GuideService;
import service.reservationGuideService;

public class main {
	public static void main(String[] args)
	{
		System.out.println("Start");
		GuideService Gs= new GuideService(); 
		reservationGuideService RGs = new reservationGuideService();
		

		//guide_touristique g1 = new guide_touristique("chouchane", "zahra", "Sousse", 23239924, "chess@@gmail.com", "winter");
		guide_touristique g2 = new guide_touristique("selmi", "ahmed", "Bizerte", 23239924, "selmi@gmail.com", "everything");
		guide_touristique g3 = new guide_touristique("selmi", "ahmed", "Bizerte", 23239924, "selmimail.com", "everything");
		guide_touristique g4 = new guide_touristique("oussema","jaouadi","sousse",23299455,"jaouadi@gmail.com","chess");

		reservation_guide r1 = new reservation_guide(46,1);
		reservation_guide r2 = new reservation_guide(47,1);
	//	Gs.insert(g1);
	//	Gs.insert(g2);
		//Gs.insert(g3);
		//Gs.delete();
		Gs.readAll();
	
		//Gs.delete(48);
		Gs.readAll();
		//Gs.update(g1,43);
	    //Gs.readAll();
		
		//RGs.insert(r1);
				//RGs.readAll();
				//	RGs.delete(4);
				//RGs.readAll();

				//RGs.insert(r2);
			//	RGs.readAll();

				//RGs.update(g2,4); 
				//RGs.readAll();

		Tesseract tesseract = new Tesseract();
		try {

			tesseract.setDatapath("C:\\Users\\Jaouadi Oussama\\eclipse-workspace\\makemy_trip\\tessdata");

			// the path of your tess data folder
			// inside the extracted file
			File x = new File("C:\\Users\\Jaouadi Oussama\\eclipse-workspace\\makemy_trip\\images\\image2.jpg");
			String text
				= tesseract.doOCR(x);

			// path of your image file
			System.out.print(text);
		}
		catch (TesseractException e) {
			e.printStackTrace();
		}

				
		
		

		
		
	}
}
