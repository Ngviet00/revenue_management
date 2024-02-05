namespace RevenueManagement.Models.Requests.User
{
    public class InformationRequest
    {
        public long? Id { get; set; }
        public string? Name { get; set; }
        public string? Phone { get; set; }
        public string? Email { get; set; }
        public string? Image { get; set; }
        public int? Sex { get; set; }
        public DateOnly? DateOfBirth { get; set; }
    }
}
