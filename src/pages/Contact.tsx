import { Header } from "@/components/layout/Header";
import { Footer } from "@/components/layout/Footer";
import { motion } from "framer-motion";
import { useState } from "react";
import { Phone, Mail, MapPin, Clock } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { toast } from "sonner";
import hero3 from "@/assets/hero-3.jpg";

// Leaflet
import { MapContainer, TileLayer, Marker, Popup, Tooltip } from "react-leaflet";
import L from "leaflet";
import "leaflet/dist/leaflet.css";

// Office images
import dubaiImg from "@/assets/Picture1.png";
import jubailImg from "@/assets/Picture1.png";
import mumbaiImg from "@/assets/Picture1.png";
import lucknowImg from "@/assets/Picture1.png";

// ---------------- CONTACT INFO ----------------
const contactInfo = [
  { icon: MapPin, title: "Address", details: ["Al Jubail Industrial City", "Kingdom of Saudi Arabia"] },
  { icon: Phone, title: "Phone", details: ["+966 133613681"] },
  { icon: Mail, title: "Email", details: ["info@metluckgroup.com.sa"] },
  { icon: Clock, title: "Working Hours", details: ["Sunday - Thursday", "8:00 AM - 5:00 PM"] },
];

// ---------------- OFFICES ----------------
const offices = [
  {
    name: "Dubai Office",
    lat: 25.276987,
    lng: 55.296249,
    image: dubaiImg,
    address: "Dubai, UAE",
  },
  {
    name: "Al Jubail Office",
    lat: 27.0,
    lng: 49.6667,
    image: jubailImg,
    address: "Al Jubail Industrial City, KSA",
  },
  {
    name: "Mumbai Office",
    lat: 19.076,
    lng: 72.8777,
    image: mumbaiImg,
    address: "Mumbai, India",
  },
  {
    name: "Lucknow Office",
    lat: 26.8467,
    lng: 80.9462,
    image: lucknowImg,
    address: "Lucknow, India",
  },
];

// ---------------- CUSTOM RED DOT ICON ----------------
const redDotIcon = new L.DivIcon({
  className: "custom-red-dot",
  iconSize: [10, 10],
  html: `<div style="width:10px; height:10px; background:red; border-radius:50%;"></div>`,
});

const Contact = () => {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    phone: "",
    subject: "",
    message: "",
  });

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
  
    console.log("Sending formData:", formData);
  
    const res = await fetch("http://localhost/api/create.php", {
      method: "POST",
      headers: {
        "Accept": "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        name: formData.name,
        email: formData.email,
        phone: formData.phone,
        subject: formData.subject,
        message: formData.message,
      }),
    });
  
    const result = await res.json();
    console.log("API Response:", result);
  
    if (result.success) {
      toast.success("Message saved successfully");
  
      setFormData({
        name: "",
        email: "",
        phone: "",
        subject: "",
        message: "",
      });
    } else {
      toast.error("Something went wrong");
    }
  };
  
  
  return (
    <div className="min-h-screen">
      <Header />

      <main>
        {/* HERO SECTION */}
        <section className="relative h-[50vh] min-h-[400px] flex items-center justify-center mt-[120px]">
          <img src={hero3} className="absolute inset-0 w-full h-full object-cover" />
          <div className="absolute inset-0 gradient-overlay" />
          <div className="relative z-10 text-white text-center">
            <motion.h1 initial={{ opacity: 0, y: 30 }} animate={{ opacity: 1, y: 0 }}
              className="text-5xl md:text-6xl font-bold mb-4">
              Contact Us
            </motion.h1>
            <motion.p initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.2 }} className="text-xl text-white/80">
              Get in Touch With Our Team
            </motion.p>
          </div>
        </section>

        {/* CONTACT INFO CARDS */}
        <section className="section-padding">
          <div className="section-container">
            <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
              {contactInfo.map((info, i) => (
                <motion.div key={info.title} initial={{ opacity: 0, y: 20 }}
                  whileInView={{ opacity: 1, y: 0 }} transition={{ delay: i * 0.1 }}
                  className="card-industrial text-center">
                  <info.icon className="w-6 h-6 mx-auto mb-3 text-primary" />
                  <h3 className="font-bold">{info.title}</h3>
                  {info.details.map((d, i) => (
                    <p key={i} className="text-sm text-muted-foreground">{d}</p>
                  ))}
                </motion.div>
              ))}
            </div>

            {/* MAP SECTION */}
            <h2 className="text-4xl font-bold text-center mb-10">Our Global Presence</h2>
            <MapContainer center={[20, 70]} zoom={3} scrollWheelZoom={true} className="w-full h-[500px] rounded-lg">
              <TileLayer
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                attribution="&copy; OpenStreetMap contributors"
              />

              {offices.map((office) => (
                <Marker
                  key={office.name}
                  position={[office.lat, office.lng]}
                  icon={redDotIcon}
                >
                  {/* Hover image */}
                  <Tooltip direction="top" offset={[0, -15]} opacity={1} permanent={false} className="p-0">
                    <img
                      src={office.image}
                      alt={office.name}
                      className="w-40 h-28 object-cover rounded-lg shadow-lg"
                    />
                  </Tooltip>

                  {/* Popup with name & address only */}
                  <Popup className="text-center">
                    <img
                      src={office.image}
                      alt={office.name}
                      className="w-40 h-28 object-cover mx-auto rounded-lg mb-2"
                    />
                    <h3 className="font-bold">{office.name}</h3>
                    <p className="text-sm">{office.address}</p>
                  </Popup>
                </Marker>
              ))}
            </MapContainer>

            {/* CONTACT FORM */}
            <div className="max-w-3xl mx-auto mt-20">
              <h2 className="text-4xl font-bold text-center mb-10">Get In Touch</h2>
              <form onSubmit={handleSubmit} className="space-y-6">
                <div className="grid md:grid-cols-2 gap-6">
                  <Input required placeholder="Full Name"
                    value={formData.name} onChange={e => setFormData({ ...formData, name: e.target.value })} />
                  <Input required type="email" placeholder="Email Address"
                    value={formData.email} onChange={e => setFormData({ ...formData, email: e.target.value })} />
                  <Input placeholder="Phone Number"
                    value={formData.phone} onChange={e => setFormData({ ...formData, phone: e.target.value })} />
                  <Input required placeholder="Subject"
                    value={formData.subject} onChange={e => setFormData({ ...formData, subject: e.target.value })} />
                </div>
                <Textarea required rows={6} placeholder="Your Message"
                  value={formData.message} onChange={e => setFormData({ ...formData, message: e.target.value })} />
                <div className="text-center">
                  <Button type="submit" className="btn-hero">Send Message</Button>
                </div>
              </form>
            </div>
          </div>
        </section>
      </main>

      <Footer />

      {/* INLINE CSS */}
      <style>{`
        .gradient-overlay { background: linear-gradient(rgba(0,0,0,.5), rgba(0,0,0,.3)); }
        .card-industrial { background:#fff; padding:1.5rem; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,.08); transition:.3s; }
        .card-industrial:hover { transform:scale(1.05); }
        .leaflet-container { border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,.15); }
        .btn-hero { background:hsl(var(--primary)); color:#fff; padding:.75rem 1.5rem; border-radius:10px; font-weight:600; }
        .section-padding { padding:4rem 1rem; }
        .section-container { max-width:1280px; margin:auto; }
        .custom-red-dot { border-radius: 50%; width: 10px; height: 10px; background: red; }
      `}</style>
    </div>
  );
};
export default Contact;