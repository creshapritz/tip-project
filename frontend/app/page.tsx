"use client";
import { useRef, useState, useEffect } from "react";

export default function Home() {
  const [email, setEmail] = useState("");
  const [officeStatus, setOfficeStatus] = useState("");
  const [ticketNumber, setTicketNumber] = useState("");
  const [estimatedTime, setEstimatedTime] = useState("");
  const [peopleAhead, setPeopleAhead] = useState("");
  const modalRef = useRef<HTMLDialogElement>(null);

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    const formData = new FormData();
    formData.append("email", email);
    console.log("FORM DATA:", formData.get("email"));
    const response = await fetch(
      "http://localhost/tip-project/backend/api/email/email.php",
      {
        method: "POST",
        body: formData,
      },
    );
    const data = await response.json();
    console.log(data);
    if (data.success) {
      modalRef.current?.showModal();
      setTicketNumber(data.ticket_no);
      setEstimatedTime(data.appointment_time);
      setPeopleAhead(data.people_ahead);
      setEmail("");
    } else {
      console.error(data.message);
    }
  };

  useEffect(() => {
    const getOfficeAvailability = async () => {
      try {
        const response = await fetch(
          "http://localhost/tip-project/backend/api/office/office_availability.php",
        );
        const data = await response.json();
        console.log(data);
        if (data.success) {
          setOfficeStatus(data.status);
        }
      } catch (error) {
        console.error("Error:", error);
      }
    };
    getOfficeAvailability();
  }, []);

  return (
    <div>
      <div>
        <h1>Student Accounting Office</h1>
        <h3>Technological Institute of the Philippines</h3>
        <div className="flex gap-1">
          <div id="officeAvailability">{officeStatus}</div>
          <div>8:00 AM - 5:00 PM</div>
        </div>
      </div>

      {!ticketNumber ? (
        <form onSubmit={handleSubmit}>
          <input
            required
            type="email"
            name="email"
            placeholder="Input email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />
          <button type="submit" disabled={officeStatus === "Closed"}>
            Submit
          </button>
        </form>
      ) : (
        <div className="flex flex-col gap-1">
          Your Ticket number {ticketNumber}
          <div className="flex gap-1">
            <div>Now Serving {ticketNumber}</div>
            <div>
              ESTIMATED WAIT TIME {estimatedTime} mins {peopleAhead} people
              ahead of you
            </div>
            <div>PEOPLE AHEAD OF YOU {peopleAhead}</div>
          </div>
          <div>
            We'll notify you when you're almost next!<br></br>
            Please stay tune to your email and within the area and prepare
            requirements.
          </div>
        </div>
      )}

      <dialog ref={modalRef} className="modal">
        <form method="dialog" className="modal-box">
          <h3 className="font-bold text-lg">Congratulations!</h3>
          <p className="py-4">You have successfully submitted your email.</p>
          <div className="modal-action">
            <button className="btn" onClick={() => modalRef.current?.close}>
              Close
            </button>
          </div>
        </form>
      </dialog>
      <footer>Powered by NexQ</footer>
    </div>
  );
}
