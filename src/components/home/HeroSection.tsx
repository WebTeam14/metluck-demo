import { useState, useEffect } from "react";
import { motion, AnimatePresence } from "framer-motion";
import { Link } from "react-router-dom";

/* ===== Image Imports (24 Images) ===== */
import picture1 from "@/assets/Picture1.png";
import picture2 from "@/assets/Picture2.png";
import picture3 from "@/assets/Picture3.jpg";
import picture4 from "@/assets/Picture4.jpg";
import picture5 from "@/assets/Picture5.jpg";
import picture6 from "@/assets/Picture6.jpg";
import picture7 from "@/assets/Picture7.jpg";
import picture8 from "@/assets/Picture8.jpg";
import picture9 from "@/assets/Picture9.jpg";
import picture10 from "@/assets/Picture10.jpg";
import picture11 from "@/assets/Picture11.jpg";
import picture12 from "@/assets/Picture12.jpg";
import picture13 from "@/assets/Picture13.jpg";
import picture14 from "@/assets/Picture14.jpg";
import picture15 from "@/assets/Picture15.jpg";
import picture16 from "@/assets/Picture16.jpg";
import picture17 from "@/assets/Picture17.jpg";
import picture18 from "@/assets/Picture18.jpg";
import picture19 from "@/assets/Picture19.jpg";
import picture20 from "@/assets/Picture20.jpg";
import picture21 from "@/assets/Picture21.jpg";
import picture22 from "@/assets/Picture22.jpg";
import picture23 from "@/assets/Picture23.jpg";
import picture24 from "@/assets/Picture24.jpg";

/* ===== Slides Data ===== */
const heroSlides = [
  { image: picture1, subtitle: "Our Office" },
  { image: picture2, subtitle: "Our Factory" },
  { image: picture3, subtitle: "Industrial Services" },
  { image: picture4, subtitle: "Industrial Services" },
  { image: picture5, subtitle: "Engineering and Construction Services" },
  { image: picture6, subtitle: "Engineering and Construction Services" },
  { image: picture7, subtitle: "Vessel, Tank, Spools & Skid Fabrication" },
  { image: picture8, subtitle: "Engineering and Construction Services" },
  { image: picture9, subtitle: "Fabrication and Pipeline Jobs" },
  { image: picture10, subtitle: "Fabrication and Pipeline Jobs" },
  { image: picture11, subtitle: "Plant Construction" },
  { image: picture12, subtitle: "Civil Construction Services" },
  { image: picture13, subtitle: "Civil Construction Services" },
  { image: picture14, subtitle: "Equipment Rental Services" },
  { image: picture15, subtitle: "Equipment Rental Services" },
  { image: picture16, subtitle: "Equipment Rental Services" },
  { image: picture17, subtitle: "Equipment Rental Services" },
  { image: picture18, subtitle: "Equipment Rental Services" },
  { image: picture19, subtitle: "Facility Management Services" },
  { image: picture20, subtitle: "Scaffolding Services" },
  { image: picture21, subtitle: "Scaffolding Services" },
  { image: picture22, subtitle: "IT & Software Solutions for Business" },
  { image: picture23, subtitle: "IT & Software Solutions for Business" },
  { image: picture24, subtitle: "Manpower Supply & Services" },
];

export function HeroSection() {
  const [currentSlide, setCurrentSlide] = useState(0);

  /* ===== Auto Slide ===== */
  useEffect(() => {
    const interval = setInterval(() => {
      setCurrentSlide((prev) => (prev + 1) % heroSlides.length);
    }, 5000);
    return () => clearInterval(interval);
  }, []);

  return (
    <section className="relative h-screen min-h-[700px] overflow-hidden">
      
      {/* ===== Background Images ===== */}
      {heroSlides.map((slide, index) => (
        <div
          key={index}
          className={`absolute inset-0 transition-opacity duration-1000 ${
            index === currentSlide ? "opacity-100" : "opacity-0"
          }`}
        >
          <img
            src={slide.image}
            alt={`Slide ${index + 1}`}
            className="w-full h-full object-cover"
          />
        </div>
      ))}

      {/* Overlay */}
      <div className="absolute inset-0 gradient-overlay" />

      {/* ===== CENTER CONTENT ===== */}
      <div className="relative z-10 h-full flex items-center justify-center text-center px-4">
        <AnimatePresence mode="wait">
          <motion.div
            key={currentSlide}
            initial={{ opacity: 0, scale: 0.95, y: 30 }}
            animate={{ opacity: 1, scale: 1, y: 0 }}
            exit={{ opacity: 0, scale: 0.95, y: -30 }}
            transition={{ duration: 0.7 }}
            className="max-w-5xl w-full"
          >
            <h1 className="text-5xl md:text-7xl lg:text-8xl font-heading font-bold text-primary-foreground mb-6">
              METLUCK
              <span className="block text-primary">GROUP</span>
            </h1>

            <p className="text-xl md:text-2xl lg:text-3xl text-primary-foreground/85 mb-10 leading-relaxed">
              {heroSlides[currentSlide].subtitle}
            </p>

            <div className="flex justify-center gap-6">
              <Link to="/services" className="btn-hero px-8 py-4 text-base">
                Explore Services
              </Link>
              <Link to="/contact" className="btn-outline-hero px-8 py-4 text-base">
                Contact Us
              </Link>
            </div>
          </motion.div>
        </AnimatePresence>
      </div>

      {/* ===== Slide Indicators ===== */}
      <div className="absolute bottom-28 left-1/2 -translate-x-1/2 flex gap-2">
        {heroSlides.map((_, index) => (
          <button
            key={index}
            onClick={() => setCurrentSlide(index)}
            className={`h-3 rounded-full transition-all ${
              index === currentSlide
                ? "bg-primary w-10"
                : "bg-primary-foreground/40 w-3 hover:bg-primary-foreground/70"
            }`}
          />
        ))}
      </div>
    </section>
  );
}
