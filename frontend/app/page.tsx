"use client";

import Image from "next/image";
import { useRef, useState } from "react";

export default function Home() {
  const [email, setEmail] = useState("");
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
      setEmail("");
    } else {
      console.error(data.message);
    }
  };

  return (
    <div>
      <form onSubmit={handleSubmit}>
        <input
          required
          type="email"
          name="email"
          placeholder="Input email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />
        <button type="submit">Submit</button>
      </form>

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
    </div>
  );
}
