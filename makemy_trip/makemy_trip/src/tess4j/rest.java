package tess4j;

import java.io.File;

import net.sourceforge.tess4j.Tesseract;
import net.sourceforge.tess4j.TesseractException;

import net.sourceforge.tess4j.*;

public class rest {
	public static void main(String[] args)
	{
		Tesseract tesseract = new Tesseract();
		try {

			tesseract.setDatapath("C:\\Users\\Jaouadi Oussama\\eclipse-workspace\\tess4j\\tessdata");

			// the path of your tess data folder
			// inside the extracted file
			File x = new File("C:\\Users\\Jaouadi Oussama\\eclipse-workspace\\tess4j\\images\\image2.JPG");
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
