declare global {
  interface Date {
    toShortDateString(): string;
  }
}

Date.prototype.toShortDateString = function (): string {
  const year = this.getFullYear();
  const month = String(this.getMonth() + 1).padStart(2, "0");
  const day = String(this.getDate()).padStart(2, "0");
  return `${year}${month}${day}`;
};

export {};
